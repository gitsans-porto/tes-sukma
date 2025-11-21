<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'penduduk_id',
        'jenis_mutasi',
        'tanggal_kejadian',
        'lokasi_detail',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
    ];

    /**
     * Get the penduduk that owns the mutasi.
     * Menggunakan withTrashed() untuk memastikan data penduduk yang sudah di-soft delete (MENINGGAL)
     * tetap bisa diakses dari log mutasi. Ini penting untuk integritas data dan audit trail.
     */
    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class)->withTrashed();
    }
}