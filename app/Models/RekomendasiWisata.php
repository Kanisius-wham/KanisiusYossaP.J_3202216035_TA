<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiWisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tempat', 'gambar', 'link_sosmed', 'deskripsi'
    ];

  protected $table = 'rekomendasi_wisata';
}
