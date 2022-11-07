<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbicacionDireccion extends Model
{
    protected $table = 'mtoma_ubicacion';

    protected $fillable = [
        'cod_ubicacion',
        'dsc_ubicacion',
        'cod_nivel',
        'dsc_observacion',
        'cod_ubicacion_sup',
        'flg_activo',
        'cod_localidad',
        'dsc_direccion',
        'cod_ubicacion_per',
        'cod_cliente',
        'num_linea',
        'cod_contacto'
    ];
}
