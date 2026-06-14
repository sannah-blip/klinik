<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriKunjungan extends Model
{
    use HasFactory;

    protected $table = 'kategori_kunjungans';

    protected $fillable = [
        'nama_kategori'
    ];

    public function kunjunganPasiens()
    {
        return $this->hasMany(KunjunganPasien::class);
    }
}