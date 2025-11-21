<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom deleted_at untuk implementasi Soft Deletes pada model Penduduk
     * Ini akan menyembunyikan penduduk yang MENINGGAL dari view aktif tetapi tetap mempertahankan data
     * untuk integritas log mutasi dan keperluan audit.
     */
    public function up(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            // Tambahkan kolom deleted_at untuk soft deletes
            // Kolom ini akan diisi otomatis oleh Laravel saat menggunakan soft delete
            $table->softDeletes();

            // Index untuk optimasi query pada deleted_at
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            // Hapus index terlebih dahulu
            $table->dropIndex(['deleted_at']);

            // Hapus kolom deleted_at
            $table->dropSoftDeletes();
        });
    }
};