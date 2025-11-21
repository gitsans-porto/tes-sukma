<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penambahan extends Model
{
    protected $fillable = [
        'id_penambahan',
        'id_penduduk',
        'jenis_penambahan',
        'tanggal_penambahan',
        'keterangan',
    ];
}
