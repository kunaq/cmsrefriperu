<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\SubTipoIncidente;
use Illuminate\Support\Facades\DB;


class SubtipoIncidenteController extends Controller
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

    //-------------------- Filtrado de subtipos por tipo ------------------------

    public function postBuscarSubtipoIncidente(Request $request){
        try{
            $codtipo    = $request->idtipo;
            $lstsubtipo = DB::table('mtoma_subtipoincidente as subtipo')
                         ->select('subtipo.cod_subtipoincidente', 'subtipo.dsc_subtipoincidente')
                         ->where('subtipo.cod_tipoincidente', '=', $codtipo)
                         ->where('subtipo.flg_activo', '=', 'SI')
                         ->orderBy('subtipo.dsc_subtipoincidente')
                         ->get();

            $html = '<option value="0">[seleccione sub-tipo]</option>';

            foreach($lstsubtipo as $subtipo){
                $html .= '<option value="'.$subtipo->cod_subtipoincidente.'">'.$subtipo->dsc_subtipoincidente.'</option>';
            }

            echo $html;

        }catch(\Exception $e){
           echo 'error'; 
        }
        
    }
}
