<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KunjunganPasien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'Admin'
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user123'),
            'role' => 'User'
        ]);

        // Seed Kategori Kunjungan
        $kategoriList = [
            ['nama_kategori' => 'Pemeriksaan Umum'],
            ['nama_kategori' => 'Gigi & Mulut'],
            ['nama_kategori' => 'Kesehatan Ibu & Anak'],
            ['nama_kategori' => 'Spesialis Penyakit Dalam'],
        ];
        foreach ($kategoriList as $kat) {
            \App\Models\KategoriKunjungan::create($kat);
        }

        // Seed Dokter
        $dokterList = [
            ['nama_dokter' => 'dr. Budi Santoso', 'spesialisasi' => 'Umum', 'jadwal_jaga' => 'Senin - Jumat (08:00 - 14:00)'],
            ['nama_dokter' => 'drg. Ani Lestari', 'spesialisasi' => 'Gigi', 'jadwal_jaga' => 'Senin - Rabu (10:00 - 15:00)'],
            ['nama_dokter' => 'dr. Citra Amelia', 'spesialisasi' => 'Anak', 'jadwal_jaga' => 'Kamis - Sabtu (09:00 - 13:00)'],
        ];
        foreach ($dokterList as $dok) {
            \App\Models\Dokter::create($dok);
        }

        // Seed sample kunjungan pasien
        KunjunganPasien::factory(15)->create([
            'dokter_id' => fn() => \App\Models\Dokter::inRandomOrder()->first()->id,
            'kategori_kunjungan_id' => fn() => \App\Models\KategoriKunjungan::inRandomOrder()->first()->id,
        ]);
    }
}

