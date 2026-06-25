<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Reservation;

class FrontController extends Controller
{
    // Untuk menampilkan Landing Page (Beranda)
    public function landing()
    {
        // 1. Mengambil 4 paket terbaru
        $featuredPackages = Package::latest()->take(4)->get();

        // 2. Ambil semua data reservasi (di-load beserta relasi paketnya agar kita tahu durasinya)
        // Opsional: Kamu bisa tambahkan ->where('status', '!=', 'Dibatalkan') kalau punya fitur status
        $reservations = Reservation::with('package')->get();

        $bookedDatesData = [];

        // 3. Looping data reservasi untuk dikelompokkan per tanggal
        foreach ($reservations as $res) {
            $date = $res->reservation_date;

            // Asumsi kolom jam di tabel reservasimu bernama 'reservation_time'
            // Sesuaikan jika namamu beda (misal: 'waktu_reservasi', 'jam', dll)
            $time = date('H:i', strtotime($res->reservation_time));

            // Mengambil durasi dari relasi paket (misal: "2 Jam" atau "Seharian")
            $duration = $res->package ? $res->package->duration : 'Durasi tidak diketahui';

            // Menggabungkan teks jam dan durasi untuk ditampilkan di pop-up
            $timeLabel = $time . ' WIB (' . $duration . ')';

            // Jika tanggal ini belum ada di array, kita buatkan rumahnya dulu
            if (!isset($bookedDatesData[$date])) {
                $bookedDatesData[$date] = [
                    'booked_hours' => [],
                    'is_seharian' => false,
                    'booking_count' => 0
                ];
            }

            // Masukkan jam yang sudah terbooking ke dalam array tanggal tersebut
            $bookedDatesData[$date]['booked_hours'][] = $timeLabel;
            $bookedDatesData[$date]['booking_count'] += 1;

            // Logika cerdas: Mengecek apakah ada pelanggan yang booking pakai paket "Seharian"
            if (stripos($duration, 'seharian') !== false || stripos($duration, 'full') !== false) {
                $bookedDatesData[$date]['is_seharian'] = true;
            }
        }

        // 4. Proses akhir: Menentukan apakah tanggal tersebut FULL (Merah) atau PARTIAL (Kuning)
        foreach ($bookedDatesData as $date => $data) {
            // Studio dianggap FULL BOOKED jika:
            // 1. Ada yang pesan paket seharian, ATAU
            // 2. Dalam sehari sudah ada 4 antrian (Kamu bisa ubah angka 4 ini sesuai kemampuan maksimal studomu)
            if ($data['is_seharian'] || $data['booking_count'] >= 4) {
                $bookedDatesData[$date]['status'] = 'full';
            } else {
                $bookedDatesData[$date]['status'] = 'partial';
            }
        }

        // 5. Kirim data yang sudah matang ini ke view 'welcome'
        return view('welcome', compact('featuredPackages', 'bookedDatesData'));
    }

    // Untuk menampilkan Katalog lengkap
    public function catalog()
    {
        $photographyPackages = Package::where('category', 'photography')->get();
        $cetakPackages = Package::where('category', 'cetak')->get();

        return view('catalog', compact('photographyPackages', 'cetakPackages'));
    }

    // Untuk menampilkan halaman Tentang Kami & Lokasi
    public function about()
    {
        return view('about');
    }
}
