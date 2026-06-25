<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;

class AdminReservationController extends Controller
{
    // Menampilkan semua reservasi untuk admin
   public function index()
    {
        // 1. Ambil data khusus Jasa Fotografi
        $photoReservations = Reservation::whereHas('package', function ($query) {
            $query->where('category', 'photography');
        })->latest()->get();

        // 2. Ambil data khusus Cetak Foto (asumsi selain photography)
        $printReservations = Reservation::whereHas('package', function ($query) {
            $query->where('category', '!=', 'photography');
        })->latest()->get();

        // 3. Data untuk Chart.js
        $chartData = Reservation::join('packages', 'reservations.package_id', '=', 'packages.id')
            ->selectRaw('packages.name, count(*) as total')
            ->groupBy('packages.name')
            ->get();

        // 4. Data Statistik / Summary Cards
        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $completedReservations = Reservation::where('status', 'completed')->count();
        $totalRevenue = Reservation::whereIn('status', ['confirmed', 'completed'])
            ->join('packages', 'reservations.package_id', '=', 'packages.id')
            ->sum('packages.price');

        // =========================================================
        // 5. LOGIKA UNTUK KALENDER PINTAR ADMIN
        // =========================================================
        $kalenderReservations = Reservation::whereHas('package', function($query) {
            $query->where('category', 'photography');
        })->whereIn('status', ['pending', 'confirmed'])->with('package')->get();

        $bookedDatesData = [];

        foreach ($kalenderReservations as $res) {
            $date = $res->reservation_date;
            $time = substr($res->reservation_time, 0, 5); // Ambil format HH:MM
            $duration = $res->package ? $res->package->duration : '';
            $isSeharian = (stripos($duration, 'seharian') !== false || stripos($duration, 'full') !== false);

            if (!isset($bookedDatesData[$date])) {
                $bookedDatesData[$date] = [
                    'status' => 'partial',
                    'booked_hours' => [],
                    'is_seharian' => false
                ];
            }

            if ($time && $time != '00:00') {
                $bookedDatesData[$date]['booked_hours'][] = $time;
            }

            if ($isSeharian || count($bookedDatesData[$date]['booked_hours']) >= 4) {
                $bookedDatesData[$date]['is_seharian'] = true;
                $bookedDatesData[$date]['status'] = 'full';
            }
        }
        // =========================================================

        return view('admin.reservations.index', [
            'photoReservations' => $photoReservations,
            'printReservations' => $printReservations,
            'labels' => $chartData->pluck('name'),
            'totals' => $chartData->pluck('total'),
            'totalReservations' => $totalReservations,
            'pendingReservations' => $pendingReservations,
            'completedReservations' => $completedReservations,
            'totalRevenue' => $totalRevenue,
            // Kirim data kalender ke View
            'bookedDatesData' => $bookedDatesData,
        ]);
    }

    // FUNGSI BARU UNTUK INPUT RESERVASI OFFLINE OLEH ADMIN
    // Menampilkan halaman form input offline
    public function create()
    {
        // Ambil data paket fotografi untuk ditampilkan di dropdown
        $packages = Package::where('category', 'photography')->get();
        return view('admin.reservations.create', compact('packages'));
    }

    // Menyimpan data dari form offline ke database
   public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_name' => 'required|string',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'location' => 'required|string',
        ]);

        // SINKRONISASI FORMAT JAM: Ubah "14:00" menjadi "14:00:00" agar cocok dengan database
        $bookingTime = $request->reservation_time;
        if (strlen($bookingTime) === 5) {
            $bookingTime .= ':00';
        }

        // --- SATPAM ANTI DOUBLE BOOKING KHUSUS ADMIN ---
        $isBooked = Reservation::where('reservation_date', $request->reservation_date)
            ->where('reservation_time', $bookingTime) // Perbandingan menggunakan jam yang sudah disinkronkan
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereHas('package', function($q) {
                $q->where('category', 'photography');
            })
            ->exists();

        if ($isBooked) {
            return back()->withInput()->with('error', 'Gagal! Jam ' . $request->reservation_time . ' di tanggal tersebut sudah terisi. Silakan cek kalender dan pilih jam lain.');
        }
        // ------------------------------------------------

        $notes = "[OFFLINE] A/N: " . $request->customer_name;

        Reservation::create([
            'user_id' => Auth::id(),
            'package_id' => $request->package_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $bookingTime,
            'location' => $request->location,
            'notes' => $notes,
            'status' => 'confirmed',
            'payment_proof' => 'offline.png'
        ]);

        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi offline berhasil dicatat!');
    }

    // mengubah status reservasi (misal: konfirmasi, tolak, selesai)
    public function updateStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:pending,confirmed,rejected,completed,cancelled',
        ]);

        // Cari reservasi berdasarkan ID, lalu update statusnya
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => $request->status]);

        // kembali ke halaman admin dengan pesan sukses
        return back()->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari data reservasi berdasarkan ID
        $reservation = Reservation::findOrFail($id);

        // Hapus data
        $reservation->delete();

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Data reservasi berhasil dihapus selamanya.');
    }

    public function report(Request $request)
    {
        // Mulai merakit query untuk mengambil data dari tabel reservations
        $query = Reservation::with(['user', 'package']);

        // Jika admin memasukkan filter tanggal mulai dan tanggal akhir
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('reservation_date', [$request->start_date, $request->end_date]);
        }

        // Ambil hasil datanya
        $reservations = $query->orderBy('reservation_date', 'desc')->get();

        // Lempar data ke file View laporan
        return view('admin.reservations.report', compact('reservations'));
    }
}
