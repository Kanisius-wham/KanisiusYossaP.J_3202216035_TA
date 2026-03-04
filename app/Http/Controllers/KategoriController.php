<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index($id_kategori = null)
    {
        $kategoris = \App\Models\Kategori::all();
    
        if ($id_kategori) {
            $alats = \App\Models\Alat::where('id_kategori', $id_kategori)->get();
            $activeKategori = $id_kategori;
        } else {
            $alats = \App\Models\Alat::all();
            $activeKategori = null;
        }
        return view('kategori', compact('kategoris', 'alats', 'activeKategori'));
    }
    



}
