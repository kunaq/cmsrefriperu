<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    public $timestamps = false;  //Se pone esto, para que cuando se grabe, Laravel no agregue las columnas:[updated_at], [created_at]
    public $primaryKey = 'cod_incidente';

    protected $table   = 'mtoca_incidente';

    protected $fillable = [
        'cod_incidente',
        'cod_tipoincidente',
        'cod_subtipoincidente',
        'fch_reporte',
        'cod_cliente',
        'num_linea',
        'cod_contacto',
        'cod_prioridad',
        'dsc_incidente',
        'dsc_detalleincidente',
        'cod_equipo',
        'cod_estadoincidente',
        'cod_canalreporte',
        'fch_registro',
        'cod_usuarioregistro',
        'cod_origenregistro',
        'cod_trabajador'
    ];
}
