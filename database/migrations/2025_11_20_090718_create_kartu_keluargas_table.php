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
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->id(); // Primary Key (ini nanti yang dipakai relasi)
            
            // Nomor KK harus unik, tidak boleh ada 2 KK dengan nomor sama
            $table->string('no_kk', 16)->unique(); 
            
            // Data Sosial Ekonomi (Dibuat nullable karena opsional di form)
            $table->string('kategori_sejahtera')->nullable(); // Misal: KS1, KS2
            $table->string('jenis_bangunan')->nullable();     // Misal: Permanen
            $table->string('pemakaian_air')->nullable();      // Misal: PDAM
            $table->string('jenis_bantuan')->nullable();      // Misal: PKH
            
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_keluarga');
    }
};