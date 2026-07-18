<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    // menampilkan form reservasi untuk paket tertentu
    public function index()
    {
        // Ambil semua reservasi milik user yang sedang login
        $reservations = Reservation::where('user_id', Auth::id())->get();

        // FIX ERROR: Ambil 3 paket paling laku untuk ditampilkan di halaman riwayat
        $featuredPackages = Package::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take(3)
            ->get();

        // Kirim $reservations dan $featuredPackages ke tampilan
        return view('reservations.index', compact('reservations', 'featuredPackages'));
    }

    // menampilkan form reservasi untuk paket tertentu
    public function create(Request $request)
    {
        // Cegah error kalau ada yang iseng akses halaman form tanpa pilih paket
        if (!$request->package_id) {
            return redirect()->route('home')->with('error', 'Silakan pilih paket terlebih dahulu dari halaman depan.');
        }

        // Cari data paket yang dipilih dari database
        $package = Package::findOrFail($request->package_id);

        // Arahkan ke form yang berbeda sesuai kategorinya
        if ($package->category == 'photography') {

            // 1. Ambil semua data reservasi khusus fotografi beserta relasi paketnya
            $reservations = Reservation::whereHas('package', function($query) {
                $query->where('category', 'photography');
            })->with('package')->get();

            $dateGroups = [];
            $fullyBookedDates = [];

            // 2. Kelompokkan dan hitung kuota per tanggal
            foreach ($reservations as $res) {
                $date = $res->reservation_date;
                $duration = $res->package ? $res->package->duration : '';

                if (!isset($dateGroups[$date])) {
                    $dateGroups[$date] = [
                        'count' => 0,
                        'is_seharian' => false
                    ];
                }

                $dateGroups[$date]['count'] += 1;

                if (stripos($duration, 'seharian') !== false || stripos($duration, 'full') !== false) {
                    $dateGroups[$date]['is_seharian'] = true;
                }
            }

            // 3. Filter mana saja tanggal yang BENAR-BENAR sudah penuh
            foreach ($dateGroups as $date => $data) {
                if ($data['is_seharian'] || $data['count'] >= 4) {
                    $fullyBookedDates[] = $date; // Masukkan ke daftar tanggal terblokir
                }
            }

            // Kirim HANYA tanggal yang sudah penuh ke view agar tanggal kuning/partial tetap bisa diklik
            return view('reservations.create_photo', [
                'package' => $package,
                'bookedDates' => $fullyBookedDates
            ]);

        } else {
            // KHUSUS CETAK: Tidak perlu mengirim tanggal karena kalendernya sudah kita sembunyikan
            return view('reservations.create_cetak', compact('package'));
        }
    }

    // menyimpan data reservasi baru
    public function store(Request $request)
    {
        // REVISI SIDANG: Menambahkan 'after_or_equal:tomorrow' pada reservation_date
        // Agar pelanggan hanya bisa booking minimal H-1 (besok dan seterusnya)
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'reservation_date' => 'required|date|after_or_equal:tomorrow',
            'reservation_time' => 'nullable',
            'location' => 'nullable|string',
            'gdrive_link' => 'nullable|url',
            'notes' => 'nullable|string',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ], [
            // Kustomisasi pesan error agar lebih ramah untuk user
            'reservation_date.after_or_equal' => 'Pemesanan maksimal H-1. Silakan pilih tanggal besok atau hari berikutnya ya!'
        ]);

        $package = Package::findOrFail($request->package_id);

        // SINKRONISASI FORMAT JAM: Ubah "14:00" menjadi "14:00:00"
        $bookingTime = $request->reservation_time;
        if ($bookingTime && strlen($bookingTime) === 5) {
            $bookingTime .= ':00';
        }

        // SATPAM ANTI DOUBLE BOOKING KHUSUS FOTOGRAFI (1 JAM BLOKIR)
        if ($package->category == 'photography' && $bookingTime) {

            $waktuMulai = Carbon::parse($bookingTime);
            $batasBawah = (clone $waktuMulai)->subMinutes(59)->format('H:i:s');
            $batasAtas  = (clone $waktuMulai)->addMinutes(59)->format('H:i:s');

            $isBooked = Reservation::where('reservation_date', $request->reservation_date)
                ->whereBetween('reservation_time', [$batasBawah, $batasAtas])
                ->whereIn('status', ['pending', 'confirmed'])
                ->whereHas('package', function($q) {
                    $q->where('category', 'photography');
                })
                ->exists();

            if ($isBooked) {
                return back()->withInput()->with('error', 'Waduh! Waktu jam ' . substr($bookingTime, 0, 5) . ' berbenturan dengan sesi foto lain. Silakan pilih jadwal lain ya!');
            }
        }
        // ----------------------------------------------------

        $data = [
            'user_id' => Auth::id(),
            'package_id' => $request->package_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $bookingTime ?? '00:00:00',
            'location' => $request->location ?? '-',
            'gdrive_link' => $request->gdrive_link,
            'notes' => $request->notes,
            'status' => 'pending',
        ];

        if ($request->hasFile('payment_proof')) {
            // Menyimpan secara private ke folder 'payments'
            $data['payment_proof'] = $request->file('payment_proof')->store('payments');
        }

        Reservation::create($data);

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dibuat! Bukti pembayaran akan segera kami proses.');
    }

    // buat upload ulang bukti pembayaran
    public function uploadPayment(Request $request, string $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        $reservation = Reservation::findOrFail($id);

        // Pastikan hanya pemilik reservasi yang bisa upload
        if ($reservation->user_id != Auth::id()) {
            abort(403);
        }

        if ($request->hasFile('payment_proof')) {
            // REVISI: Simpan ke folder 'payments' secara private (tanpa 'public')
            $path = $request->file('payment_proof')->store('payments');

            // Simpan nama path ke database
            $reservation->update(['payment_proof' => $path]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil dikirim!');
    }

    public function show(Reservation $reservation) {}
    public function edit(Reservation $reservation) {}
    public function update(Request $request, Reservation $reservation) {}
    public function destroy(Reservation $reservation) {}
}
