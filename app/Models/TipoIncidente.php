<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIncidente extends Model
{
    protected $table = 'mtoma_tipoincidente';

    protected $fillable = [
        'cod_tipoincidente',
        'dsc_tipoincidente',
        'flg_activo'
    ];
}
