<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteCentroResponsabilidad extends Model
{
    protected $table = 'vtade_cliente_centroresponsabilidad';

    protected $fillable = [
        'cod_cliente',
        'cod_centroresp',
        'dsc_centroresp',
        'dsc_centroresp_cliente',
        'flg_activo',
        'flg_consolidador',
        'num_nivel',
        'cod_centroresp_sup',
        'num_linea',
        'cod_contacto'
    ];
}
