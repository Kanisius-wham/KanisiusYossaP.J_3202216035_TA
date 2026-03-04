<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_penyewaan';
    protected $fillable = ['id_pelanggan', 'id_admin', 'tanggal_sewa', 'status_penyewaan'];


public function pelanggan() {
    return $this->belongsTo(\App\Models\Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
}
public function detailPenyewaan() {
    return $this->hasMany(\App\Models\DetailPenyewaan::class, 'id_penyewaan', 'id_penyewaan');
}

}

