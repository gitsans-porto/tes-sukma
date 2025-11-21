<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluarga';
    protected $guarded = [];

    // Relasi: Satu KK punya banyak Penduduk
    public function anggota(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'kartu_keluarga_id');
    }

    // Alias untuk konsistensi naming
    public function penduduk(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'kartu_keluarga_id');
    }
}