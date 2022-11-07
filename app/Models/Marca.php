<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'feima_marca_articulo';

    protected $fillable = [
        'cod_marca',
        'dsc_marca',
        'flg_nacional',
        'flg_extranjero',
        'flg_activo',
        'flg_para_producto',
        'flg_para_equipos'
    ];
}
