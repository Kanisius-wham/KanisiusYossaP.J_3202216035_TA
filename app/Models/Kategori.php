<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;
    protected $fillable = [
        'nama_kategori',
    ];

    public function alats()
    {
        return $this->hasMany(Alat::class, 'id_kategori');
    }
}
