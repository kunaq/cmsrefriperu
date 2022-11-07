<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Ciclo;
use App\Models\Incidencia;
use App\Http\Controllers\IncidenciaController;
use Illuminate\Support\Facades\DB;


class CicloController extends Controller
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
    
    public function getIndexCiclo(){

        $listado  = DB::table('sgema_ciclo as ciclo')
                  ->select('ciclo.cod_ciclo', 'ciclo.dsc_ciclo','ciclo.dsc_observacion','ciclo.flg_activo')
                  ->get();

        //Sacamos el total de incidedentes
        $ctotal   = IncidenciaController::totalIncidencias();       

        return view('pages.ciclo.index',compact('listado','ctotal'));
    }

    public function getProcedmiento(Request $Request){
        /*try{
          $fila = DB::select('EXEC INGRESO ?,?,?,?',['CLIENTE','20543374858','donato','123456']);
          //dd($fila);
          $num = sizeof($fila);   
          //dd($num);
          if($num>0){
            $code    = $fila[0]->Codigo;
            $ruc     = $fila[0]->RUC;
            $usuario = $fila[0]->cod_usuario_web;
          }else{
            $code   = 'Credenciales no validas';
          }

          return $code;
         
        }catch(\Exception $e){
            DB::rollback();
            return $this->redirectToHome();    
        }*/

        $role = config('constants.roles_name.cliente');

        return $role;
    }
}
