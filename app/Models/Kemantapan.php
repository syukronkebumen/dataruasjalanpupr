<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kemantapan extends Model
{
    protected $table = 'tbl_kemantapan';
    protected $fillable = [
        'id_kemantapan',
        'id_ruasjln',
        'panjang_jln_km',
        'lebar_jln_m',
        'baik_km',
        'baik_persen',
        'sedang_km',
        'sedang_persen',
        'rusak_ringan_km',
        'rusak_ringan_persen',
        'rusak_berat_km',
        'rusak_berat_persen',
        'ket'
    ];
}
