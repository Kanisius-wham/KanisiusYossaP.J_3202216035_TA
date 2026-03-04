<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\alat;
use App\Models\Kategori;
use App\Models\GaleriPendakian;
use App\Models\RekomendasiWisata;

class BerandaController extends Controller
{
    public function index()
{
    $alats = alat::with('kategori')->orderBy('created_at', 'desc')->take(10)->get();
    $kategoris = Kategori::all();
    $pendakian = GaleriPendakian::all();
    $wisata = RekomendasiWisata::all();

    return view('beranda', compact('alats', 'kategoris','pendakian','wisata'));
}


}

