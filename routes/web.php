<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // WAJIB TAMBAHKAN INI UNTUK MEMBACA FILE DENGAN AMAN
use App\Http\Controllers\PackageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AdminUserController;

// Halaman utama (Landing Page)
Route::get('/', [FrontController::class, 'landing'])->name('home');

// Halaman Tentang Kami & Lokasi
Route::get('/about', [FrontController::class, 'about'])->name('about');

// Halaman Katalog Paket
Route::get('/katalog', [FrontController::class, 'catalog'])->name('catalog');

// === Rute Akses Publik (Auth) ===
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// === ROUTES UNTUK PELANGGAN BUKAN ADMIN ===
Route::middleware('auth')->group(function () {
    Route::resource('reservations', ReservationController::class);

    // =========================================================================
    // FITUR BARU: Route Penjaga Pintu untuk Private Storage (Bukti Pembayaran)
    // =========================================================================
    Route::get('/payment-proof/{id}', function ($id) {
        $reservation = \App\Models\Reservation::findOrFail($id);

        // Cek keamanan: Yang boleh lihat cuma Admin atau si pelanggan yang punya struk
        if (Auth::user()->role !== 'admin' && Auth::id() !== $reservation->user_id) {
            abort(403, 'Akses Ditolak: Anda tidak diizinkan melihat dokumen rahasia ini.');
        }

        $file = $reservation->payment_proof;

        // LOGIKA PINTAR V2: Menggunakan Storage Facade (Best Practice Laravel)
        // 1. Cek disk 'local' (Brankas rahasia / Private Storage untuk pesanan baru)
        if (Storage::disk('local')->exists($file)) {
            return response()->file(Storage::disk('local')->path($file));
        }
        // 2. Cek disk 'public' (Public Storage untuk pesanan lama)
        elseif (Storage::disk('public')->exists($file)) {
            return response()->file(Storage::disk('public')->path($file));
        }
        // Jika keduanya tidak ada
        else {
            abort(404, 'Bukti pembayaran tidak ditemukan di dalam sistem server.');
        }
    })->name('payment.proof');
});

// Upload bukti pembayaran
Route::post('/reservations/{id}/upload-payment', [ReservationController::class, 'uploadPayment'])->name('reservations.upload_payment');


// === ROUTES KHUSUS ADMIN ===
Route::middleware(['auth', IsAdmin::class])->group(function () {

    //Reservasi Admin
    Route::get('/admin/reservations/create', [AdminReservationController::class, 'create'])->name('admin.reservations.create');
    Route::post('/admin/reservations', [AdminReservationController::class, 'store'])->name('admin.reservations.store');

    // Dashboard & Reservasi
    Route::get('/admin/reservations', [AdminReservationController::class, 'index'])->name('admin.reservations.index');
    Route::post('/admin/reservations/{id}/status', [AdminReservationController::class, 'updateStatus'])->name('admin.reservations.update_status');

    // Tombol hapus reservasi
    Route::delete('/admin/reservations/{id}', [AdminReservationController::class, 'destroy'])->name('admin.reservations.destroy');

    // Route Laporan Admin
    Route::get('/admin/report', [AdminReservationController::class, 'report'])->name('admin.reservations.report');

    // Kelola User / Hak Akses
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{id}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.update_role');

    // CRUD Paket (Cukup di sini saja karena ini area Admin)
    Route::resource('admin/packages', PackageController::class)->names([
        'index' => 'admin.packages.index',
        'create' => 'admin.packages.create',
        'store' => 'admin.packages.store',
        'edit' => 'admin.packages.edit',
        'update' => 'admin.packages.update',
        'destroy' => 'admin.packages.destroy',
    ]);

    // Mengecek notifikasi pesanan baru (AJAX)
    Route::get('/admin/check-new-orders', [AdminReservationController::class, 'checkNewOrders'])->name('admin.check_orders');
});
