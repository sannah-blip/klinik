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
        Schema::table('kunjungan_pasiens', function (Blueprint $table) {
            $table->text('tindakan')->nullable()->after('keluhan_utama');
            $table->text('pemberian_obat')->nullable()->after('tindakan');
        });

        // Copy existing data from tindakan_obat to tindakan
        DB::table('kunjungan_pasiens')->update([
            'tindakan' => DB::raw('tindakan_obat')
        ]);

        Schema::table('kunjungan_pasiens', function (Blueprint $table) {
            $table->dropColumn('tindakan_obat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungan_pasiens', function (Blueprint $table) {
            $table->text('tindakan_obat')->nullable()->after('keluhan_utama');
        });

        // Copy back
        DB::table('kunjungan_pasiens')->update([
            'tindakan_obat' => DB::raw('tindakan')
        ]);

        Schema::table('kunjungan_pasiens', function (Blueprint $table) {
            $table->dropColumn(['tindakan', 'pemberian_obat']);
        });
    }
};
