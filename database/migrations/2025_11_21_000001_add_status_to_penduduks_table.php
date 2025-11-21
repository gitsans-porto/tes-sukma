<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom status untuk melacak status kehidupan penduduk
     */
    public function up(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            // Kolom status untuk tracking status penduduk (HIDUP, MENINGGAL, PINDAH)
            $table->enum('status', ['HIDUP', 'MENINGGAL', 'PINDAH'])->default('HIDUP')->after('dusun');

            // Index untuk optimasi query berdasarkan status
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            // Hapus index terlebih dahulu
            $table->dropIndex(['status']);

            // Hapus kolom status
            $table->dropColumn('status');
        });
    }
};