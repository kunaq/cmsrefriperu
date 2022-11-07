<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoIncidente extends Model
{
    protected $table = 'mtoma_estado_incidente';

    protected $fillable = [
        'cod_estadoincidente',
        'dsc_estadoincidente',
        'flg_activo'
    ];
}
