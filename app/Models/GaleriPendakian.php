<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriPendakian extends Model
{
    use HasFactory;

  
    protected $fillable = [
        'nama', 'gambar', 'deskripsi'
    ];


 protected $table = 'galeri_pendakian';
}
