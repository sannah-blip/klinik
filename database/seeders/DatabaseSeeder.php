<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KunjunganPasien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Admin & Regular User)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123', // Otomatis di-hash oleh cast Laravel 11
            'role' => 'Admin'
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => 'user123',
            'role' => 'User'
        ]);

        // 2. Seed Kategori Kunjungan (Menggunakan kolom 'nama_kategori')
        $kategoriList = [
            ['nama_kategori' => 'Pemeriksaan Umum'],
            ['nama_kategori' => 'Gigi & Mulut'],
            ['nama_kategori' => 'Kesehatan Ibu & Anak'],
            ['nama_kategori' => 'Spesialis Penyakit Dalam'],
        ];
        foreach ($kategoriList as $kat) {
            \App\Models\KategoriKunjungan::create($kat);
        }

        // 3. Seed Dokter (Menggunakan format dinamis agar cocok dengan JavaScript filter tanggal)
        $dokterList = [
            [
                'nama_dokter' => 'dr. Budi Santoso', 
                'spesialisasi' => 'Umum', 
                'jadwal_mulai' => now()->startOfDay()->format('Y-m-d H:i:s'), 
                'jadwal_selesai' => now()->addDays(7)->endOfDay()->format('Y-m-d H:i:s')
            ],
            [
                'nama_dokter' => 'drg. Ani Lestari', 
                'spesialisasi' => 'Gigi', 
                'jadwal_mulai' => now()->startOfDay()->format('Y-m-d H:i:s'), 
                'jadwal_selesai' => now()->addDays(7)->endOfDay()->format('Y-m-d H:i:s')
            ],
            [
                'nama_dokter' => 'dr. Citra Amelia', 
                'spesialisasi' => 'Anak', 
                'jadwal_mulai' => now()->startOfDay()->format('Y-m-d H:i:s'), 
                'jadwal_selesai' => now()->addDays(7)->endOfDay()->format('Y-m-d H:i:s')
            ],
        ];
        foreach ($dokterList as $dok) {
            \App\Models\Dokter::create($dok);
        }

        // 4. Seed 15 Sample Kunjungan Pasien Manual (Menghindari error SQLite foreign key)
        $statuses = ['Mahasiswa', 'Dosen', 'Staf', 'Umum'];
        
        for ($i = 1; $i <= 15; $i++) {
            $dokter = \App\Models\Dokter::inRandomOrder()->first();
            
            KunjunganPasien::create([
                'nama_pasien' => 'Pasien Dummy ' . $i,
                'status' => Arr::random($statuses),
                'tanggal_kunjungan' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'keluhan_utama' => 'Keluhan kesehatan dummy untuk simulasi sistem klinik.',
                'tindakan' => 'Pemeriksaan tanda vital dan konsultasi medis.',
                'pemberian_obat' => 'Paracetamol 500mg, Vitamin C.',
                'nama_dokter' => $dokter->nama_dokter,
                'dokter_id' => $dokter->id,
            ]);
        }

        // 5. Seed Clinic Info
        \App\Models\ClinicInfo::create([
            'nama_klinik' => 'Klinik Kampus',
            'jam_operasional' => '08:00 - 16:00',
            'kontak_darurat' => 'Ext-119',
            'deskripsi' => 'Sistem Informasi Klinik Kampus siap digunakan. Pantau antrean, kelola riwayat pemeriksaan, dan berikan pelayanan kesehatan terbaik hari ini.'
        ]);
    }
}