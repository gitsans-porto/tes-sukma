<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('mutasis', function (Blueprint $table) {
        $table->id();
        // Hubungkan ke tabel penduduks
        $table->foreignId('penduduk_id')->constrained('penduduks')->onDelete('cascade');
        
        $table->enum('jenis_mutasi', ['LAHIR', 'MENINGGAL', 'DATANG', 'PINDAH']);
        $table->date('tanggal_kejadian');
        $table->string('lokasi_detail')->nullable(); // Misal: RSUD, Desa Sebelah
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};