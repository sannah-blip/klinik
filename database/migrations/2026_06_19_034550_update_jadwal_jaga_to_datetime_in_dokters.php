<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            $table->dateTime('jadwal_mulai')->nullable()->after('spesialisasi');
            $table->dateTime('jadwal_selesai')->nullable()->after('jadwal_mulai');
        });

        // Drop the old string column
        Schema::table('dokters', function (Blueprint $table) {
            $table->dropColumn('jadwal_jaga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            $table->string('jadwal_jaga')->nullable()->after('spesialisasi');
        });

        Schema::table('dokters', function (Blueprint $table) {
            $table->dropColumn(['jadwal_mulai', 'jadwal_selesai']);
        });
    }
};
