<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'gsema_equipo';

    protected $fillable = [
        'cod_equipo',
        'cod_tipo_equipo',
        'dsc_equipo',
        'cod_interno',
        'cod_activo',
        'num_serie',
        'num_parte',
        'cod_marca',
        'cod_modelo',
        'cod_proveedor',
        'fch_compra',
        'cod_moneda',
        'imp_compra',
        'fch_registro',
        'dsc_observacion',
        'num_mes_garantia',
        'num_mes_mnto',
        'flg_equipo_cliente',
        'cod_cliente',
        'cod_localidad',
        'num_pedido',
        'cod_estado',
        'cod_subtipo_equipo',
        'cod_usuario_reg',
        'cod_empresa',
        'cod_centroresp',
        'flg_equipo_compuesto',
        'cod_ubicacion',
        'cod_motivo_baja',
        'fch_baja',
        'cod_usuario_baja',
        'dsc_detalle_baja',
        'cod_responsable_equipo',
        'cod_subactivo',
        'cod_inventario',
        'fch_inicio_operacion',
        'flg_ctrl_horometro',
        'ctd_hmto_plan_dia',
        'fch_fabricacion',
        'fch_instalacion',
        'num_nivel_criticidad',
        'dsc_imagen',
        'dsc_resolucion_baja',
        'fch_ult_mantenimiento',
        'flg_importado',
        'fch_importacion',
        'imp_costo_mto',
        'cod_centroresp_cliente'
	];
}
