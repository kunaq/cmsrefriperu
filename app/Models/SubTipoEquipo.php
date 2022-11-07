<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTipoEquipo extends Model
{
    protected $table = 'cod_subtipo_equipo';

    protected $fillable = [
        'cod_subtipo_equipo',
        'cod_tipo_equipo',
        'dsc_subtipo_equipo',
        'flg_activo',
        'dsc_observaciones',
        'flg_importado',
        'fch_importacion'
    ];
}
