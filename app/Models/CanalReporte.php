<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanalReporte extends Model
{
    protected $table = 'mtoma_canalreporte';

    protected $fillable = [
        'cod_canalreporte',
        'dsc_canalreporte',
        'flg_activo'
    ];
}
