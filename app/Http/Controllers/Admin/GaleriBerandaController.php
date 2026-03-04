<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriPendakian;
use App\Models\RekomendasiWisata;

class GaleriBerandaController extends Controller
{
        public function index()
    {
        $pendakian = GaleriPendakian::latest()->get();
        $wisata = RekomendasiWisata::latest()->get();
        return view('admin.galeri_beranda.index', compact('pendakian', 'wisata'));
    }
}
