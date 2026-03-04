<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;

class AlatController extends Controller
{
    // Tampilkan form tambah alat
public function create()
{
    $kategoris = \App\Models\Kategori::all();
    return view('admin.alat.create', compact('kategoris'));
}

// Proses simpan alat baru
public function store(Request $request)
{
    $validated = $request->validate([
        'nama_alat' => 'required|string|max:255',
        'id_kategori' => 'required|exists:kategoris,id_kategori',
        'harga_sewa_per_hari' => 'required|integer|min:0',
        'stok' => 'required|integer|min:0',
        'deskripsi' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Handle upload foto
    if($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('alats', 'public');
        $validated['foto'] = basename($fotoPath);
    }

    \App\Models\Alat::create($validated);

    return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan!');
}
public function index()
{
    $alats = \App\Models\Alat::with('kategori')->get();
    return view('admin.alat.index', compact('alats'));
}
// edit alat
public function edit($id)
{
    $alat = \App\Models\Alat::findOrFail($id);
    $kategoris = \App\Models\Kategori::all();
    return view('admin.alat.edit', compact('alat', 'kategoris'));
}

public function update(Request $request, $id)
{
    $alat = \App\Models\Alat::findOrFail($id);

    $validated = $request->validate([
        'nama_alat' => 'required|string|max:255',
        'id_kategori' => 'required|exists:kategoris,id_kategori',
        'harga_sewa_per_hari' => 'required|integer|min:0',
        'stok' => 'required|integer|min:0',
        'deskripsi' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    if($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('alats', 'public');
        $validated['foto'] = basename($fotoPath);
    }

    $alat->update($validated);

    return redirect()->route('admin.alat.index')->with('success', 'Data alat berhasil diperbarui!');
}

// hapus alat
public function destroy($id)
{
    $alat = \App\Models\Alat::findOrFail($id);
    $alat->delete();

    return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus!');
}



}
