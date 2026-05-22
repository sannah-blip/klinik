<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganPasien extends Model
{
    /** @use HasFactory<\Database\Factories\KunjunganPasienFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_pasien',
        'status',
        'tanggal_kunjungan',
        'keluhan_utama',
        'tindakan_obat',
        'nama_dokter',
    ];
}

