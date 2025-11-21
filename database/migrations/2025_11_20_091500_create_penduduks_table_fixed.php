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
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id(); // Primary Key otomatis Laravel

            // Relasi ke kartu_keluarga
            $table->foreignId('kartu_keluarga_id')->nullable();

            // Data Penduduk (sesuai form & controller)
            $table->string('nik', 16)->unique(); // NIK 16 digit unik
            $table->string('nama'); // nama lengkap
            $table->string('jenis_kelamin'); // Laki-laki/Perempuan
            $table->string('tempat_lahir');
            $table->date('tgl_lahir'); // sesuai controller
            $table->integer('usia')->nullable(); // dihitung otomatis
            $table->string('pekerjaan');
            $table->string('hubungan_keluarga'); // Kepala Keluarga, Istri, Anak, dll
            $table->string('tamatan'); // SD, SMP, SMA, dll
            $table->string('dusun')->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('kartu_keluarga_id')->references('id')->on('kartu_keluarga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};