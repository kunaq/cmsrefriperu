<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteContacto extends Model
{
    protected $table = 'vtade_cliente_contacto';

    protected $fillable = [
        'cod_cliente',
        'cod_contacto',
        'dsc_nombre',
        'dsc_apellidos',
        'fch_nacimiento',
        'dsc_correo',
        'dsc_telefono1',
        'dsc_telefono2',
        'dsc_cargo',
        'fch_registro',
        'cod_usuario_reg',
        'cod_usuario_web',
        'cod_clave_web'
    ];
}
