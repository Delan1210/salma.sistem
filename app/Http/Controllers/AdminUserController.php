<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index()
    {
        // Ambil semua data user
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Mencegah admin mengubah rolenya sendiri (biar gak sengaja ke-lock out)
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Kamu tidak bisa mengubah role akunmu sendiri saat sedang login!');
        }

        // Update role
        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', 'Role untuk ' . $user->name . ' berhasil diperbarui!');
    }
}
