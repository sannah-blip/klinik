<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dokter;
use App\Models\User;

class KunjunganPasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pasien',
        'status',
        'tanggal_kunjungan',
        'keluhan_utama',
        'tindakan',
        'pemberian_obat',
        'dokter_id',
        'kategori_kunjungan_id',
        'dokumen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriKunjungan()
    {
        return $this->belongsTo(
            KategoriKunjungan::class,
            'kategori_kunjungan_id'
        );
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }   
}