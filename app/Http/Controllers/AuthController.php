<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_telp' => 'required|min:10',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'role' => 'customer'
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login!');
    }

    // Ini adalah satu-satunya function untuk memproses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Memeriksa role pengguna
            if (Auth::user()->role === 'admin') {
                // Kalau Admin, lempar ke Dashboard Admin
                return redirect('/admin/reservations')->with('success', 'Selamat datang Admin!');
            }

            // Kalau bukan admin (customer), lempar langsung ke halaman Home (Katalog)
            return redirect('/')->with('success', 'Login berhasil! Silakan pilih paket fotografi yang kamu inginkan.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
