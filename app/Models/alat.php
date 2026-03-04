<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_alat'; 
    protected $fillable = ['nama_alat', 'id_kategori', 'harga_sewa_per_hari', 'stok', 'deskripsi', 'foto'];

    public function kategori()
    {
        return $this->belongsTo(\App\Models\Kategori::class, 'id_kategori', 'id_kategori');
    }
}
