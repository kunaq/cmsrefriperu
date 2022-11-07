<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTipoIncidente extends Model
{
    protected $table = 'mtoma_subtipoincidente';

    protected $fillable = [
    	'cod_subtipoincidente',
        'cod_tipoincidente',
        'dsc_subtipoincidente',
        'flg_activo'
    ];
}
