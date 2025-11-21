<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Penduduk extends Model
{
    use SoftDeletes; // Enable soft deletes functionality

    protected $table = 'penduduks'; // Explicit table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'usia',
        'pekerjaan',
        'hubungan_keluarga',
        'tamatan',
        'kartu_keluarga_id',
        'dusun',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tgl_lahir' => 'date',
        'nik' => 'string',
        'usia' => 'integer',
    ];

    // Hitung usia otomatis
    public function getUsiaAttribute($value)
    {
        if ($this->tgl_lahir) {
            return Carbon::parse($this->tgl_lahir)->age;
        }
        return $value;
    }

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    // Accessor untuk menampilkan no_kk dari relasi
    public function getNoKkAttribute()
    {
        return $this->kartuKeluarga->no_kk ?? null;
    }

    // Accessor untuk compatibility dengan index.blade.php
    public function getPeranKeluargaAttribute()
    {
        return $this->hubungan_keluarga;
    }

    /**
     * Get the display version of jenis_kelamin
     */
    public function getJenisKelaminDisplayAttribute()
    {
        switch ($this->jenis_kelamin) {
            case 'L':
                return 'Laki-laki';
            case 'P':
                return 'Perempuan';
            default:
                return $this->jenis_kelamin;
        }
    }

    /**
     * Get the mutasis for the penduduk.
     */
    public function mutasis(): HasMany
    {
        return $this->hasMany(Mutasi::class);
    }
}
