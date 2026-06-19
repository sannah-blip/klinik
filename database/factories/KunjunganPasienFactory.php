<?php

namespace Database\Factories;

use App\Models\KunjunganPasien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KunjunganPasien>
 */
class KunjunganPasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    return [

        'nama_pasien' => fake()->name(),

        'status' => fake()->randomElement([
            'Mahasiswa',
            'Staf',
            'Umum'
        ]),
        'tanggal_kunjungan' => fake()->date(),
        'keluhan_utama' => fake()->sentence(),
        'tindakan' => fake()->sentence(),
        'pemberian_obat' => fake()->sentence(),
        'nama_dokter' => fake()->name(),
    ];
}
}