<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `kunjungan_pasiens` MODIFY `status` ENUM('Mahasiswa','Dosen','Staf','Umum') NOT NULL");

        DB::table('kunjungan_pasiens')
            ->where('status', 'Dosen')
            ->update(['status' => 'Staf']);

        DB::statement("ALTER TABLE `kunjungan_pasiens` MODIFY `status` ENUM('Mahasiswa','Staf','Umum') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `kunjungan_pasiens` MODIFY `status` ENUM('Mahasiswa','Dosen','Staf','Umum') NOT NULL");

        DB::table('kunjungan_pasiens')
            ->where('status', 'Staf')
            ->update(['status' => 'Dosen']);

        DB::statement("ALTER TABLE `kunjungan_pasiens` MODIFY `status` ENUM('Mahasiswa','Dosen','Umum') NOT NULL");
    }
};
