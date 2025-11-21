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
        Schema::create('penambahans', function (Blueprint $table) {
            $table->integer('id_penambahan')->primary();
            $table->integer('id_penduduk');
            $table->enum('jenis_penambahan', ['lahir', 'datang']); // sesuaikan sendiri
            $table->date('tanggal_penambahan');
            $table->string('keterangan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penambahans');
    }
};
