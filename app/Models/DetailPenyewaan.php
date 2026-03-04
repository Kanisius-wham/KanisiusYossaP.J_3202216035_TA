<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenyewaan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_detail';
    protected $fillable = [
        'id_penyewaan', 'id_alat', 'jumlah_hari', 'jumlah_alat', 'subtotal'
    ];

    public function alat() {
        return $this->belongsTo(\App\Models\Alat::class, 'id_alat', 'id_alat');
    }
    
}

