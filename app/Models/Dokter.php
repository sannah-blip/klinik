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
        'jadwal_mulai',
        'jadwal_selesai',
    ];

    public function getJadwalJagaAttribute()
    {
        return $this->jadwal_formatted;
    }

    public function getJadwalFormattedAttribute()
    {
        if (!$this->jadwal_mulai || !$this->jadwal_selesai) {
            return '-';
        }
        $start = \Carbon\Carbon::parse($this->jadwal_mulai);
        $end = \Carbon\Carbon::parse($this->jadwal_selesai);
        if ($start->isSameDay($end)) {
            return $start->translatedFormat('d M Y, H:i') . ' - ' . $end->translatedFormat('H:i');
        }
        return $start->translatedFormat('d M Y, H:i') . ' - ' . $end->translatedFormat('d M Y, H:i');
    }

    public function kunjunganPasiens()
    {
        return $this->hasMany(KunjunganPasien::class);
    }
}