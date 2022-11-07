<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    
    public $timestamps = false;
    public $primaryKey = 'cod_cliente';

    protected $table = 'vtama_cliente';

    protected $fillable = [
        'cod_cliente',
        'dsc_razon_social',
        'dsc_apellido_paterno',
        'dsc_apellido_materno',
        'dsc_nombre',
        'flg_juridico',
        'cod_tipo_documento',
        'dsc_documento',
        'cod_calificacion',
        'dsc_email',
        'dsc_telefono1',
        'dsc_telefono2',
        'dsc_cliente',
        'cod_tipo_contacto',
        'cod_usuario',
        'fch_registro',
        'cod_sexo',
        'cod_estadocivil',
        'cod_categoria',
        'cod_cliente_antiguo',
        'fch_fallecimiento',
        'fch_nacimiento',
        'dsc_mail_trabajo',
        'cod_tipo_cliente',
        'flg_domiciliado',
        'cod_vendedor',
        'cod_modalidad_venta',
        'flg_vinculada',
        'cod_tarjeta_cliente',
        'dsc_mail_fe',
        'cod_cliente_interno',
        'flg_padron_envio',
        'flg_afiliacion',
        'cod_empresa_interna',
        'dsc_cargo',
        'dsc_carben',
        'flg_tipo_planilla',
        'num_dias_gracia',
        'cod_modulo',
        'cod_modular',
        'dsc_contacto'
    ];
}
