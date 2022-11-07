<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    protected $table = 'sgema_ciclo';

    protected $fillable = [
        'cod_ciclo',
        'dsc_ciclo',
        'dsc_observacion',
        'flg_activo'
    ];
}
