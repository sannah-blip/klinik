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
        // User::factory(10)->create();

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

        // Seed sample kunjungan pasien
        KunjunganPasien::factory(15)->create();
    }
}

