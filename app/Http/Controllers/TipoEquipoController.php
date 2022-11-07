<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\TipoEquipo;
use App\Models\SubTipoEquipo;
use App\Models\Incidencia;
use App\Http\Controllers\IncidenciaController;
use Illuminate\Support\Facades\DB;


class TipoEquipoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */

    public function __construct()
    {
        $this->middleware('autenticado');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
    */
    
    public function postBuscarSubtipo(Request $request){
      try{
          $codtipo     = $request->code;
          $lstsubtipo  = DB::table('gsema_subtipo_equipo as subtipo')
                         ->select('subtipo.cod_subtipo_equipo', 'subtipo.dsc_subtipo_equipo','subtipo.flg_activo')
                         ->where('subtipo.cod_tipo_equipo', '=', $codtipo)
                         ->orderBy('subtipo.dsc_subtipo_equipo')
                         ->get();

          $html = '<option value="0">[Todos]</option>';

          foreach($lstsubtipo as $subtipo){
            $html .= '<option value="'.$subtipo->cod_subtipo_equipo.'">'.$subtipo->dsc_subtipo_equipo.'</option>';
          }

          echo $html;

      }catch(\Exception $e){
        return $this->errorResponse();
      }  
    }
}
