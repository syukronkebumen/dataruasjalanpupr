<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuasJalan extends Model
{
    protected $table = 'tb_ruas_jln';
    protected $fillable = [
        'id_ruasjln',
        'nama_ruasjln',
        'panjang_jln',
        'id_fungsijln',
        'kec_jalan',
        'wilayah',
        'no_ruasjln',
        'jumlah_titik',
        'ruas_geom'
    ];
}
