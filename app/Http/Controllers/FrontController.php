<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Reservation;

class FrontController extends Controller
{
    // Untuk menampilkan Landing Page (Beranda)
    public function landing()
    {
        // 1. Mengambil 3 paket PALING BANYAK DIPESAN (Untuk Section Favorit)
        $featuredPackages = Package::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take(3)
            ->get();

        // 2. Mengambil 4 paket FOTOGRAFI terbaru (Paket Cetak Foto DIBLOKIR dari galeri)
        $galleryPackages = Package::where('category', 'photography')
            ->latest()
            ->take(4)
            ->get();

        // Ambil semua data reservasi (di-load beserta relasi paketnya agar kita tahu durasinya)
        $reservations = Reservation::with('package')->get();

        $bookedDatesData = [];

        foreach ($reservations as $res) {
            $date = $res->reservation_date;
            $time = date('H:i', strtotime($res->reservation_time));
            $duration = $res->package ? $res->package->duration : 'Durasi tidak diketahui';
            $timeLabel = $time . ' WIB (' . $duration . ')';

            if (!isset($bookedDatesData[$date])) {
                $bookedDatesData[$date] = [
                    'booked_hours' => [],
                    'is_seharian' => false,
                    'booking_count' => 0
                ];
            }

            $bookedDatesData[$date]['booked_hours'][] = $timeLabel;
            $bookedDatesData[$date]['booking_count'] += 1;

            if (stripos($duration, 'seharian') !== false || stripos($duration, 'full') !== false) {
                $bookedDatesData[$date]['is_seharian'] = true;
            }
        }

        foreach ($bookedDatesData as $date => $data) {
            if ($data['is_seharian'] || $data['booking_count'] >= 4) {
                $bookedDatesData[$date]['status'] = 'full';
            } else {
                $bookedDatesData[$date]['status'] = 'partial';
            }
        }

        // PASTIKAN VARIABLE $galleryPackages IKUT DIKIRIM KE VIEW
        return view('welcome', compact('featuredPackages', 'galleryPackages', 'bookedDatesData'));
    }

    // Untuk menampilkan Katalog lengkap
    public function catalog()
    {
        // REVISI BEST SELLER: Hitung total reservasi dan urutkan dari yang terbanyak
        $photographyPackages = Package::where('category', 'photography')
            ->withCount('reservations')
            ->orderByDesc('reservations_count')
            ->get();

        $cetakPackages = Package::where('category', 'cetak')
            ->withCount('reservations')
            ->orderByDesc('reservations_count')
            ->get();

        return view('catalog', compact('photographyPackages', 'cetakPackages'));
    }

    // Untuk menampilkan halaman Tentang Kami & Lokasi
    public function about()
    {
        return view('about');
    }
}
