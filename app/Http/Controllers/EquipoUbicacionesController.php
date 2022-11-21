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


class EquipoUbicacionesController extends Controller
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
    
    public function getUbicacion(Request $request){
      try{
        // codCliente : {{$codCliente}},
        //             numLinea : linea
        //select * from mtoma_ubicacion where num_linea = '6' and cod_cliente = 'CLI0000364'
          $codCliente  = $request->codCliente;
          $numLinea = $request->numLinea;
          $listaUbicacion  = DB::table('mtoma_ubicacion as ubicacion')
                         ->select('ubicacion.dsc_ubicacion', 'ubicacion.cod_ubicacion','ubicacion.cod_ubicacion_sup')
                         ->where('ubicacion.cod_cliente', '=', $codCliente)
                         ->where('ubicacion.num_linea', '=', $numLinea)
                         ->where('ubicacion.cod_nivel', '=', 'N01')
                         ->where('ubicacion.flg_activo','=','SI')
                         ->orderBy('ubicacion.dsc_ubicacion')
                         ->get();

          $html = '<option value="0">[Todos]</option>';

          foreach($listaUbicacion as $lista){
            $html .= '<option value="'.$lista->cod_ubicacion.'">'.$lista->dsc_ubicacion.'</option>';
          }

          echo $html;

      }catch(\Exception $e){
        return $this->errorResponse();
      }  
    }

    public function getUbicacion2(Request $request){
      try{
        // codCliente : {{$codCliente}},
        //             numLinea : linea
        //select * from mtoma_ubicacion where num_linea = '6' and cod_cliente = 'CLI0000364' and cod_ubicacion_sup = '00000010'
          $codCliente  = $request->codCliente;
          $numLinea = $request->numLinea;
          $lineaSuperior = $request->lineaSuperior;
          $listaUbicacion  = DB::table('mtoma_ubicacion as ubicacion')
                         ->select('ubicacion.dsc_ubicacion', 'ubicacion.cod_ubicacion','ubicacion.cod_ubicacion_sup')
                         ->where('ubicacion.cod_cliente', '=', $codCliente)
                         ->where('ubicacion.num_linea', '=', $numLinea)
                         ->where('ubicacion.cod_ubicacion_sup','=', $lineaSuperior)
                         ->where('ubicacion.cod_nivel', '=', 'N02')
                         ->where('ubicacion.flg_activo','=','SI')
                         ->orderBy('ubicacion.dsc_ubicacion')
                         ->get();

          
          $html = '<option value="0">Todos</option>';

          foreach($listaUbicacion as $lista){
            $html .= '<option value="'.$lista->cod_ubicacion.'+'.$lista->cod_ubicacion_sup.'">'.$lista->dsc_ubicacion.'</option>';
          }

          echo $html;

      }catch(\Exception $e){
        return $this->errorResponse();
      }  
    }

    public function getUbicacion3(Request $request){
      try{
        // codCliente : {{$codCliente}},
        //             numLinea : linea
        //select * from mtoma_ubicacion where num_linea = '6' and cod_cliente = 'CLI0000364' and cod_ubicacion_sup = '00000010'
          $codCliente  = $request->codCliente;
          $numLinea = $request->numLinea;
          $lineaSuperior = $request->lineaSuperior;
          $listaUbicacion  = DB::table('mtoma_ubicacion as ubicacion')
                         ->select('ubicacion.dsc_ubicacion', 'ubicacion.cod_ubicacion','ubicacion.cod_ubicacion_sup')
                         ->where('ubicacion.cod_cliente', '=', $codCliente)
                         ->where('ubicacion.num_linea', '=', $numLinea)
                         ->where('ubicacion.cod_ubicacion_sup','=', $lineaSuperior)
                         ->where('ubicacion.cod_nivel', '=', 'N03')
                         ->where('ubicacion.flg_activo','=','SI')
                         ->orderBy('ubicacion.dsc_ubicacion')
                         ->get();

          
          $html = '<option value="0">Todos</option>';

          foreach($listaUbicacion as $lista){
            $html .= '<option value="'.$lista->cod_ubicacion.'+'.$lista->cod_ubicacion_sup.'">'.$lista->dsc_ubicacion.'</option>';
          }

          echo $html;

      }catch(\Exception $e){
        return $this->errorResponse();
      }  
    }
    
}