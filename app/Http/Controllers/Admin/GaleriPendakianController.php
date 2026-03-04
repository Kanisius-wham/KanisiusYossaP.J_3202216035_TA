<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GaleriPendakian;

class GaleriPendakianController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.galeri_beranda.index');
    }

    public function create()
    {
        return view('admin.galeri_pendakian.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'nullable|string|max:100',
        'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'deskripsi' => 'nullable|string'
    ]);

    if($request->hasFile('gambar')) {
        $gambarPath = $request->file('gambar')->store('galeri_pendakian', 'public');
        $validated['gambar'] = basename($gambarPath);
    }

    \App\Models\GaleriPendakian::create($validated);

    return redirect()->route('admin.galeri_beranda.index')->with('success', 'Foto pendakian berhasil ditambah');
}

public function update(Request $request, $id)
{
    $item = \App\Models\GaleriPendakian::findOrFail($id);

    $validated = $request->validate([
        'nama' => 'nullable|string|max:100',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'deskripsi' => 'nullable|string'
    ]);

    if($request->hasFile('gambar')) {
        // Hapus gambar lama (jika ada)
        if ($item->gambar && file_exists(storage_path('app/public/galeri_pendakian/' . $item->gambar))) {
            unlink(storage_path('app/public/galeri_pendakian/' . $item->gambar));
        }
        $gambarPath = $request->file('gambar')->store('galeri_pendakian', 'public');
        $validated['gambar'] = basename($gambarPath);
    }

    $item->update($validated);

    return redirect()->route('admin.galeri_beranda.index')->with('success', 'Data berhasil diupdate');
}

public function destroy($id)
{
    $item = \App\Models\GaleriPendakian::findOrFail($id);

    // Hapus file fisik
    if ($item->gambar && file_exists(storage_path('app/public/galeri_pendakian/' . $item->gambar))) {
        unlink(storage_path('app/public/galeri_pendakian/' . $item->gambar));
    }

    $item->delete();

    return redirect()->route('admin.galeri_beranda.index')->with('success', 'Data berhasil dihapus');
}

}
