<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_dokter',
        'spesialisasi',
        'jadwal_jaga',
    ];

    public function kunjunganPasiens()
    {
        return $this->hasMany(KunjunganPasien::class);
    }
}