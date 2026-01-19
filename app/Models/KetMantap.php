<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetMantap extends Model
{
    protected $table = 'tb_ket_mantap';
    protected $fillable = [
        'id_mantap',
        'ket_survey',
        'jenis_mantap',
        'mantap_persen',
        'panjang_full'
    ];
}
