<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Kolom nama_dokter sudah tidak dipakai (digantikan relasi dokter_id),
     * tapi masih NOT NULL sehingga menyebabkan error saat insert.
     * Migration ini menjadikannya nullable agar tidak mengganggu insert baru.
     */
    public function up(): void
    {
        Schema::table('kunjungan_pasiens', function (Blueprint $table) {
            $table->string('nama_dokter')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungan_pasiens', function (Blueprint $table) {
            $table->string('nama_dokter')->nullable(false)->change();
        });
    }
};
