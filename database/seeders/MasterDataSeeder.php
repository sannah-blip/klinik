<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriKunjungan;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Isi Data Kategori Kunjungan
        $kategori = [
            ['nama_kategori' => 'Umum'],
            ['nama_kategori' => 'Gigi dan Mulut'],
            ['nama_kategori' => 'Ibu dan Anak'],
            ['nama_kategori' => 'Penyakit Dalam'],
        ];

        foreach ($kategori as $k) {
            KategoriKunjungan::create($k);
        }

        // 2. Isi Data User Admin (Menyesuaikan error SQLite kemarin dengan 'Admin')
        User::create([
            'name' => 'Admin Utama Klinik',
            'email' => 'admin@klinik.com',
            'password' => 'password123', // Otomatis ter-hash oleh Laravel 11
            'role' => 'Admin' 
        ]);
    }
}