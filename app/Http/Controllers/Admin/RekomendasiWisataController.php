<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RekomendasiWisata;

class RekomendasiWisataController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.galeri_beranda.index');
    }

    public function create()
    {
        return view('admin.rekomendasi_wisata.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_tempat' => 'required|string|max:100',
        'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'link_sosmed' => 'nullable|string|max:255',
        'deskripsi' => 'nullable|string'
    ]);

    if($request->hasFile('gambar')) {
        $gambarPath = $request->file('gambar')->store('rekomendasi_wisata', 'public');
        $validated['gambar'] = basename($gambarPath);
    }

    \App\Models\RekomendasiWisata::create($validated);

    return redirect()->route('admin.galeri_beranda.index')->with('success', 'Rekomendasi wisata berhasil ditambah');
}

public function update(Request $request, $id)
{
    $item = \App\Models\RekomendasiWisata::findOrFail($id);

    $validated = $request->validate([
        'nama_tempat' => 'required|string|max:100',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'link_sosmed' => 'nullable|string|max:255',
        'deskripsi' => 'nullable|string'
    ]);

    if($request->hasFile('gambar')) {
        // Hapus gambar lama (jika ada)
        if ($item->gambar && file_exists(storage_path('app/public/rekomendasi_wisata/' . $item->gambar))) {
            unlink(storage_path('app/public/rekomendasi_wisata/' . $item->gambar));
        }
        $gambarPath = $request->file('gambar')->store('rekomendasi_wisata', 'public');
        $validated['gambar'] = basename($gambarPath);
    }

    $item->update($validated);

    return redirect()->route('admin.galeri_beranda.index')->with('success', 'Data berhasil diupdate');
}

public function destroy($id)
{
    $item = \App\Models\RekomendasiWisata::findOrFail($id);

    if ($item->gambar && file_exists(storage_path('app/public/rekomendasi_wisata/' . $item->gambar))) {
        unlink(storage_path('app/public/rekomendasi_wisata/' . $item->gambar));
    }

    $item->delete();

    return redirect()->route('admin.galeri_beranda.index')->with('success', 'Data berhasil dihapus');
}

}
