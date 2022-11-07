<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteDireccion extends Model
{
    protected $table = 'vtade_cliente_direccion';

    protected $fillable = [
        'cod_cliente',
        'num_linea',
        'cod_pais',
        'cod_departamento',
        'cod_provincia',
        'dsc_direccion',
        'cod_distrito',
        'cod_tipo_direccion',
        'dsc_referencia',
        'dsc_telefono_1',
        'dsc_telefono_2',
        'flg_comprobante',
        'cod_numero',
        'cod_interior',
        'cod_manzana',
        'cod_lote',
        'cod_sublote',
        'dsc_urbanizacion',
        'dsc_cadena_direccion',
        'flg_direccion_obra',
        'dsc_observacion',
        'dsc_nombre_direccion',
        'cod_zona',
        'flg_dreccion_cobranza',
        'cod_calle_direccion',
        'cod_urbanizacion',
        'cod_tipo_via',
        'cod_tipo_zona'
	];
}
