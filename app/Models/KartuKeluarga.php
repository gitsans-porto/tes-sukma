<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluarga';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_kk',
        'kategori_sejahtera',
        'jenis_bangunan',
        'pemakaian_air',
        'jenis_bantuan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'no_kk' => 'string',
    ];

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