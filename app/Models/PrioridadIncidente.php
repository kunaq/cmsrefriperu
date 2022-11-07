<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrioridadIncidente extends Model
{
    protected $table = 'mtoma_prioridadincidente';

    protected $fillable = [
        'cod_prioridad',
        'dsc_prioridad',
        'flg_critico',
        'flg_activo'
    ];
}
