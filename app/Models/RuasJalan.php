<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuasJalan extends Model
{
    protected $fillable = [
        'name',
        'panjang',
        'fungsi',
        'kecamatan',
        'wilayah',
        'no_ruas',
        'jumlah_titik',
        'polyline'
    ];
}
