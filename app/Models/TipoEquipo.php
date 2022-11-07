<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEquipo extends Model
{
    protected $table = 'gsema_tipo_equipo';

    protected $fillable = [
        'cod_tipo_equipo',
        'dsc_tipo_equipo',
        'flg_activo',
        'flg_importado',
        'fch_importacion'
    ];
}
