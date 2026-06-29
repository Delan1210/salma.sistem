<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Storage; // Wajib ditambahkan untuk fitur hapus file gambar

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        // Tambahan validasi untuk category dan image
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:8500'
        ]);

        $data = $request->all();

        // Cek apakah admin mengupload foto
        if ($request->hasFile('image')) {
            // Simpan foto ke folder storage/app/public/packages
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        Package::create($data);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        // Tambahan validasi untuk category dan image
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:8548'
        ]);

        $data = $request->all();

        // Cek apakah admin mengupload foto baru saat edit
        if ($request->hasFile('image')) {
            // Hapus foto lama dari storage agar memori tidak penuh
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }

            // Simpan foto baru
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        $package->update($data);
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diubah!');
    }

    public function destroy(Package $package)
    {
        // Hapus file gambar dari storage sebelum datanya dihapus dari database
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus!');
    }
}
