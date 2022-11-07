<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 'feima_modelo_articulo';

    protected $fillable = [
        'cod_tipo_articulo',
        'cod_marca',
        'cod_modelo',
        'dsc_modelo',
        'flg_activo'
    ];
}
