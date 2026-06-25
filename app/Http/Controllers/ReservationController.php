<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // menampilkan form reservasi untuk paket tertentu
    public function index()
    {
        // Ambil semua reservasi milik user yang sedang login
        $reservations = Reservation::where('user_id', Auth::id())->get();
        return view('reservations.index', compact('reservations'));
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
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'nullable',
            'location' => 'nullable|string',
            'gdrive_link' => 'nullable|url',
            'notes' => 'nullable|string',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        $package = Package::findOrFail($request->package_id);

        // SINKRONISASI FORMAT JAM: Ubah "14:00" menjadi "14:00:00"
        $bookingTime = $request->reservation_time;
        if ($bookingTime && strlen($bookingTime) === 5) {
            $bookingTime .= ':00';
        }

        // --- SATPAM ANTI DOUBLE BOOKING KHUSUS FOTOGRAFI ---
        if ($package->category == 'photography') {
            $isBooked = Reservation::where('reservation_date', $request->reservation_date)
                ->where('reservation_time', $bookingTime)
                ->whereIn('status', ['pending', 'confirmed'])
                ->whereHas('package', function($q) {
                    $q->where('category', 'photography');
                })
                ->exists();

            if ($isBooked) {
                return back()->withInput()->with('error', 'Waduh! Jam ' . $request->reservation_time . ' di tanggal tersebut baru saja dibooking orang lain. Silakan pilih jam lain ya!');
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
            $data['payment_proof'] = $request->file('payment_proof')->store('payments', 'public');
        }

        Reservation::create($data);

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dibuat! Bukti pembayaran akan segera kami proses.');
    }

    // buat upload ulang bukti pembayaran
    public function uploadPayment(Request $request, $id)
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
            // Simpan ke folder storage/app/public/payment_proofs
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

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
