<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Untuk mengecek user sudah login DAN rolenya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Silakan lewat!
        }

        // Jika bukan admin, arahkan kembali ke halaman daftar paket dengan pesan error
        return redirect('/reservations')->with('error', 'Akses ditolak');
    }
}
