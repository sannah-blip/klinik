<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicInfo extends Model
{
    protected $fillable = [
        'nama_klinik',
        'jam_operasional',
        'kontak_darurat',
        'deskripsi',
    ];
}
