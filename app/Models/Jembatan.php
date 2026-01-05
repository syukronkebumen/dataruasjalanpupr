<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jembatan extends Model
{
    protected $table = 'tb_jemb';
    protected $fillable = [
        'no_jemb',
        'nama_jemb',
        'nama_ruas_jemb',
        'id_ruasjln',
        'jemb_geom'
    ];
}
