<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminKategoriController extends Controller
{
    public function index() {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }
    public function store(Request $request) {
        $request->validate(['nama_kategori' => 'required']);
        Kategori::create(['nama_kategori' => $request->nama_kategori]);
        return back()->with('success', 'Kategori ditambahkan.');
    }
    public function update(Request $request, $id) {
        $request->validate(['nama_kategori' => 'required']);
        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama_kategori' => $request->nama_kategori]);
        return back()->with('success', 'Kategori diupdate.');
    }
    public function destroy($id) {
        Kategori::destroy($id);
        return back()->with('success', 'Kategori dihapus.');
    }
}
