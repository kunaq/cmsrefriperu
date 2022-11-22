<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Helpers\DateHelper;
use App\Helpers\AppHelper;

use Carbon\Carbon;
use App\Models\Incidencia;
use App\Models\TipoIncidente;
use App\Models\Cliente;
use App\Models\PrioridadIncidente;
use App\Models\EstadoIncidente;
use App\Models\CanalReporte;
use App\Models\Responsable;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

//Libreria Excel
use App\Exports\IncidenciaExport;
use Maatwebsite\Excel\Facades\Excel;

class IncidenciaController extends Controller{
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

    public function getIndexIncidencia(){
      //Sacamos el listado de estado
      $estados  = DB::table('mtoma_estado_incidente as estado')
                  ->select('estado.cod_estadoincidente', 'estado.dsc_estadoincidente')
                  ->where('estado.flg_activo', '=', 'SI')
                  ->orderBy('estado.dsc_estadoincidente')
                  ->get();

      //Sacamos el listado de responsables
      $respons  = DB::table('rhuma_trabajador as responsable')
                  ->select('responsable.cod_trabajador', 'responsable.dsc_nombres','responsable.dsc_apellido_paterno','responsable.dsc_apellido_materno')
                  ->orderBy('responsable.dsc_nombres')
                  ->get();

      //Sacamos la fecha
      /*$day       = '01';
      $fecha_act = Carbon::now('America/Lima'); //2020-09-18 16:43:58
      //definimos anio y mes actual
      $anio      = $fecha_act->year;
      $mes       = $fecha_act->format('m');
      $dia       = $fecha_act->format('d');
      //definimos la fecha inicial
      $finicial  = $anio.'-'.$mes.'-'.$day;

      //definimos la fecha final
      $ffinal    = $anio.'-'.$mes.'-'.$dia; */
      
      return view('pages.incidencia.index',compact('estados','respons'));

    }

    public function getListadoIncidencia(Request $request){
      try{
        
        $idstate = $request->idstate;
        $search  = $request->search;
        $fdesde  = $request->fdesde;
        $fhasta  = $request->fhasta;
        $codresp = $request->codresp;
        $codeinc = $request->codincd;

        //Se define la session del usuario
        $role    = Session()->get('rol');

        //Se hace la busqueda
        $incidencias  = DB::table('mtoca_incidente as incidente')
                      ->join('mtoma_tipoincidente','incidente.cod_tipoincidente', '=', 'mtoma_tipoincidente.cod_tipoincidente')
                      ->join('vtama_cliente','incidente.cod_cliente', '=', 'vtama_cliente.cod_cliente')
                      ->join('mtoma_prioridadincidente','incidente.cod_prioridad', '=', 'mtoma_prioridadincidente.cod_prioridad')
                      ->join('mtoma_estado_incidente','incidente.cod_estadoincidente', '=', 'mtoma_estado_incidente.cod_estadoincidente')
                      ->select('incidente.cod_incidente','mtoma_tipoincidente.dsc_tipoincidente','incidente.dsc_incidente', 'incidente.fch_reporte',
                               'incidente.cod_subtipoincidente','vtama_cliente.dsc_razon_social','mtoma_prioridadincidente.dsc_prioridad',
                               'mtoma_estado_incidente.dsc_estadoincidente','incidente.cod_estadoincidente','incidente.fch_registro');

        $total = $incidencias->count();

        if (!empty($codeinc))
          //$incidencias = $incidencias->where('incidente.cod_incidente', '=', $codeinc);
          $incidencias = $incidencias->where('incidente.cod_incidente', 'like', '%' . $codeinc . '%');

        if (!empty($idstate))
          $incidencias = $incidencias->where('incidente.cod_estadoincidente', '=', $idstate);

        if (!empty($codresp))
          $incidencias = $incidencias->where('incidente.cod_trabajador', '=', $codresp);

        if (!empty($search))
          $incidencias = $incidencias->where('vtama_cliente.dsc_razon_social', 'like', '%' . $search . '%');

        if (!empty($fdesde) && !empty($fhasta))
          $incidencias = $incidencias->whereBetween('incidente.fch_reporte', array($fdesde, $fhasta));

        //Hacemos la validacion aqui:
        if($role == config('constants.roles_name.cliente')){
          $codcli = Session()->get('cod_cli');
          $incidencias = $incidencias->where('incidente.cod_cliente', '=', $codcli);
        }

        $filtrados = $incidencias->count();

        $incidencias = $incidencias
                ->orderBy('incidente.dsc_incidente')
                ->get();

        $data = [];
        foreach ($incidencias as $item){
          array_push($data, [
            "code"           => $item->cod_incidente,
            "tipo_incidente" => $item->dsc_tipoincidente,
            "tit_incidente"  => $item->dsc_incidente,
            "fech_reporte"   => DateHelper::getDateFormat($item->fch_reporte),
            "nomcliente"     => AppHelper::clientFormat($item->dsc_razon_social),
            "prioridad"      => $item->dsc_prioridad,
            "codestado"      => $item->cod_estadoincidente,
            "estado"         => $item->dsc_estadoincidente,
            "fech_reg"       => $item->fch_registro
          ]);
        }

        $result = $this->dataTableResult($total,$filtrados,$data);

        return $result;

      }catch(\Exception $e){
        return $this->emptyCustomDataTable();
      }  
    }

    public function getCrearIncidencia(){
        $codcli  = Session()->get('cod_cli');
        //Sacamos el listado de tipos de incidente
        $tipos     = DB::table('mtoma_tipoincidente as tipoincid')
                    ->select('tipoincid.cod_tipoincidente', 'tipoincid.dsc_tipoincidente')
                    ->where('tipoincid.flg_activo', '=', 'SI')
                    ->orderBy('tipoincid.dsc_tipoincidente')
                    ->get();

        //Sacamos el listado de clientes
        $clientes = DB::table('vtade_cliente_direccion as cliente')
                    ->select('cliente.cod_cliente', 'clienteMA.dsc_razon_social','clienteMA.dsc_documento','clienteMA.dsc_cliente')
                    ->join('vtama_cliente as clienteMA','cliente.cod_cliente','=','clienteMA.cod_cliente')
                    ->where('cliente.cod_cliente', '=','CLI0000364')
                    ->where('cliente.flg_plan_activo','=','SI')
                    ->distinct()
                    ->orderBy('clienteMA.dsc_cliente')
                    ->get();

        //Sacamos el listado de prioridad
        $prioridad = DB::table('mtoma_prioridadincidente as prioridad')
                    ->select('prioridad.cod_prioridad', 'prioridad.dsc_prioridad','prioridad.flg_critico','prioridad.flg_urgente')
                    ->orderBy('prioridad.dsc_prioridad')
                    ->get();

        //Sacamos el listado de estado
        $estado   = DB::table('mtoma_estado_incidente as estado')
                    ->select('estado.cod_estadoincidente', 'estado.dsc_estadoincidente')
                    ->where('estado.flg_activo', '=', 'SI')
                    ->orderBy('estado.dsc_estadoincidente')
                    ->get();
        //Sacamos el listado de responsables
        $respons  = DB::table('rhuma_trabajador as responsable')
                    ->select('responsable.cod_trabajador', 'responsable.dsc_nombres','responsable.dsc_apellido_paterno','responsable.dsc_apellido_materno')
                    ->orderBy('responsable.dsc_nombres')
                    ->get();

        //Sacamos el listado de canales de reporte
        $canales  = DB::table('mtoma_canalreporte as canal')
                    ->select('canal.cod_canalreporte', 'canal.dsc_canalreporte')
                    ->where('canal.flg_activo', '=', 'SI')
                    ->orderBy('canal.dsc_canalreporte')
                    ->get();

        $listaSede  = DB::table('vtade_cliente_direccion as direccion')
                    ->select('direccion.dsc_nombre_direccion', 'direccion.num_linea')
                    ->where('direccion.cod_cliente', '=','CLI0000364')
                    ->orderBy('direccion.dsc_nombre_direccion')
                    ->get();

        //Fecha actual
        $fecha    = Carbon::now('America/Lima');

        return view('pages.incidencia.create',compact('tipos','clientes','prioridad','estado','respons','canales','listaSede'));
    }

    public function postCrearIncidencia(Request $request){
      try{
          DB::beginTransaction();
          //dd($request);
          //die();
          if($request->descripcion!=null){
            $detalle = $request->descripcion;
          }else{
            $detalle = '';
          }

          if($request->lstequipo!='0'){
            $codequipo = $request->lstequipo;
          }else{
            $codequipo = '';
          }

          if($request->lstresponsable!='0'){
            $codresp = $request->lstresponsable;
          }else{
            $codresp = '';
          }

          //sacamos el ultimo codigo de registro:
          $codeincidencia = IncidenciaHelper::UltimoRegistro();

          //Sacamos el id del usuario logueado
          $coduser        = $request->session()->get('coduser_reg'); //Creo que debe ser asi: Session()->get('rol');

          $codorigenreg   = 'WEB';

          Incidencia::create([
            "cod_incidente" => $codeincidencia,
            "cod_tipoincidente" => $request->lsttipo,
            "cod_subtipoincidente" => $request->lstsubtipo,
            "fch_reporte" => $request->fecha_reporte,
            "cod_cliente" => $request->lstcliente,
            "num_linea" => $request->lstlinea,
            "cod_contacto" => $request->lstcontacto,
            "cod_prioridad" => $request->lstprioridad,
            "dsc_incidente" => $request->titulo,
            "dsc_detalleincidente" => $detalle,
            "cod_equipo" => $codequipo,
            "cod_estadoincidente" => $request->lstestado,
            "cod_canalreporte" => $request->lstcanal,
            "fch_registro" => Carbon::now('America/Lima'), 
            "cod_usuarioregistro" => $coduser,
            "cod_origenregistro" =>  $codorigenreg,
            "cod_trabajador" => $codresp,
          ]);

          DB::commit();
          $this->successAlert('Se creó correctamente', 'Incidente creado');
          return redirect('incidencia');

        }catch(\Exception $e){
          DB::rollback();
          return $this->redirectToHome(); 
        }
    }

    public function getEditarIncidencia(Request $request){
      try{
        //$incidencia   = Incidencia::findOrFail($request->id);

        $code         = $request->id;
        $incidencia   = Incidencia::where('cod_incidente', $code)->firstOrFail();

        //Sacamos el listado de tipos de incidente
        $tipos     = DB::table('mtoma_tipoincidente as tipoincid')
                    ->select('tipoincid.cod_tipoincidente', 'tipoincid.dsc_tipoincidente')
                    ->where('tipoincid.flg_activo', '=', 'SI')
                    ->orderBy('tipoincid.dsc_tipoincidente')
                    ->get();

        //Sacamos el listado de subtipos de incidente
        $tipos     = DB::table('mtoma_tipoincidente as tipoincid')
                    ->select('tipoincid.cod_tipoincidente', 'tipoincid.dsc_tipoincidente')
                    ->where('tipoincid.flg_activo', '=', 'SI')
                    ->orderBy('tipoincid.dsc_tipoincidente')
                    ->get();

        $subtipos   = DB::table('mtoma_subtipoincidente as subtipo')
                    ->select('subtipo.cod_subtipoincidente', 'subtipo.dsc_subtipoincidente')
                    ->where('subtipo.cod_tipoincidente', '=', $incidencia->cod_tipoincidente)
                    ->where('subtipo.flg_activo', '=', 'SI')
                    ->orderBy('subtipo.dsc_subtipoincidente')
                    ->get();

        //Sacamos el listado de clientes
        $clientes = DB::table('vtama_cliente as cliente')
                    ->select('cliente.cod_cliente', 'cliente.dsc_razon_social','cliente.dsc_documento','cliente.dsc_cliente')
                    ->orderBy('cliente.dsc_cliente')
                    ->get();
        //Sacamos el listado de lineas de cliente
        $lineas    = DB::table('vtade_cliente_direccion as clidir')
                     ->select('clidir.num_linea', 'clidir.dsc_direccion')
                     ->where('clidir.cod_cliente', '=', $incidencia->cod_cliente)
                     ->orderBy('clidir.dsc_direccion')
                     ->get();

        //Sacamos el listado de contactos de cliente
        $contactos  = DB::table('vtade_cliente_direccion_contacto as clidircto')
                      ->select('clidircto.cod_contacto', 'clidircto.dsc_nombre','clidircto.dsc_apellidos')
                      ->where('clidircto.cod_cliente', '=', $incidencia->cod_cliente)
                      ->orderBy('clidircto.dsc_apellidos')
                      ->get();

        //Sacamos el listado de prioridad
        $prioridad = DB::table('mtoma_prioridadincidente as prioridad')
                    ->select('prioridad.cod_prioridad', 'prioridad.dsc_prioridad','prioridad.flg_critico','prioridad.flg_urgente')
                    ->orderBy('prioridad.dsc_prioridad')
                    ->get();

        //Sacamos el listado de estado
        $estado   = DB::table('mtoma_estado_incidente as estado')
                    ->select('estado.cod_estadoincidente', 'estado.dsc_estadoincidente')
                    ->where('estado.flg_activo', '=', 'SI')
                    ->orderBy('estado.dsc_estadoincidente')
                    ->get();

        //Sacamos el listado de responsables
        $respons  = DB::table('rhuma_trabajador as responsable')
                    ->select('responsable.cod_trabajador', 'responsable.dsc_nombres','responsable.dsc_apellido_paterno','responsable.dsc_apellido_materno')
                    ->orderBy('responsable.dsc_nombres')
                    ->get();

        //Sacamos el listado de canales de reporte
        $canales  = DB::table('mtoma_canalreporte as canal')
                    ->select('canal.cod_canalreporte', 'canal.dsc_canalreporte')
                    ->where('canal.flg_activo', '=', 'SI')
                    ->orderBy('canal.dsc_canalreporte')
                    ->get();

        return view('pages.incidencia.edit',compact('incidencia','tipos','subtipos','lineas','contactos','clientes','prioridad','estado','respons','canales','code')); 

      }catch(\Exception $e){
        return $this->errorResponse();
      }
    }

    public function postEditarIncidencia(Request $request){
      try{
       DB::beginTransaction();
        //$code         = $request->cod_incidente;
        //dd($code);
        //$incidencia   = Incidencia::where('cod_incidente', $code)->firstOrFail();

        $incidencia  = Incidencia::find($request->cod_incidente);

        if($request->descripcion!=null){
          $detalle   = $request->descripcion;
        }else{
          $detalle   = '';
        }

        if($request->lstequipo!='0'){
          $codequipo = $request->lstequipo;
        }else{
          $codequipo = '';
        }

        if($request->lstresponsable!='0'){
          $codresp = $request->lstresponsable;
        }else{
          $codresp = '';
        }

        //Sacamos el id del usuario logueado
        //$coduser     = $request->session()->get('coduser_reg') //Auth::user()->id;

        $incidencia->cod_tipoincidente    = $request->lsttipo;
        $incidencia->cod_subtipoincidente = $request->lstsubtipo;
        $incidencia->fch_reporte          = $request->fecha_reporte;
        $incidencia->cod_cliente          = $request->lstcliente;
        $incidencia->num_linea            = $request->lstlinea;
        $incidencia->cod_contacto         = $request->lstcontacto;
        $incidencia->cod_prioridad        = $request->lstprioridad;
        $incidencia->dsc_incidente        = $request->titulo;
        $incidencia->dsc_detalleincidente = $detalle;
        $incidencia->cod_equipo           = $codequipo;
        $incidencia->cod_estadoincidente  = $request->lstestado;
        $incidencia->cod_canalreporte     = $request->lstcanal;
        //$incidencia->cod_usuarioregistro  = $coduser;
        $incidencia->cod_trabajador       = $codresp;
        $incidencia->save();

        DB::commit();
        $this->successAlert('Se editó correctamente', 'Incidente editado');
        return redirect('incidencia');   

      }catch(\Exception $e){
        DB::rollback();
        return $this->redirectToHome();  
      }  
    }

    public function eliminarIncidente(Request $request){
      try{
        $incidencia = Incidencia::findOrFail($request->code);
        $incidencia->delete();
        echo 'ok';
      }catch(\Exception $e){
        echo 'error';   //Error
      }  
    }

    public function resumenIncidente(){
      try{
        //Sacamos el total de incidedentes
        $total    = DB::table('mtoca_incidente')
                  ->select(DB::raw('count(cod_incidente) as total_incidentes'))
                  ->get();
        $ctotal   = $total[0]->total_incidentes;

        //Sacamos la cantidad de incidentes pendientes
        $totalp   = DB::table('mtoca_incidente')
                  ->select(DB::raw('count(cod_incidente) as cant_incidentes_pend'))
                  ->where('cod_estadoincidente', '=', '001')
                  ->get();
        $ctotalp  = $totalp[0]->cant_incidentes_pend;

        //Sacamos la cantidad de incidentes en proceso
        $totproc  = DB::table('mtoca_incidente')
                  ->select(DB::raw('count(cod_incidente) as cant_incidentes_proc'))
                  ->where('cod_estadoincidente', '=', '002')
                  ->get();
        $ctotproc = $totproc[0]->cant_incidentes_proc;

        //Sacamos la cantidad de incidentes atendidos
        $totatend = DB::table('mtoca_incidente')
                  ->select(DB::raw('count(cod_incidente) as cant_incidentes_cerr'))
                  ->where('cod_estadoincidente', '=', '003')
                  ->get();
        $ctotatend= $totatend[0]->cant_incidentes_cerr;

        //Sacamos la cantidad de incidentes cancelados
        $totcanc  = DB::table('mtoca_incidente')
                  ->select(DB::raw('count(cod_incidente) as cant_incidentes_cancel'))
                  ->where('cod_estadoincidente', '=', '004')
                  ->get();
        $ctotcanc = $totcanc[0]->cant_incidentes_cancel;

        //dd($totalp[0]->cant_incidentes_pend);
        //die();
        return view('pages.incidencia.resumen',compact('ctotal','ctotalp','ctotproc','ctotatend','ctotcanc'));

      }catch(\Exception $e){
        DB::rollback();
        return $this->redirectToHome();  
      } 
       
    }

    public static function totalIncidencias(){
      //Sacamos el total de incidedentes
      $total    = DB::table('mtoca_incidente')
                ->select(DB::raw('count(cod_incidente) as total_incidentes'))
                ->get();
      $ctotal   = $total[0]->total_incidentes;
      
      return $ctotal;  
    }

    public function getestadoIncidenciaAnio(Request $request){
      try{
        //Sacamos la cantidad de incidentes pendientes por año
        $anio     = $request->anio;
        $totalp   = DB::select(DB::raw("SELECT COUNT(cod_incidente) AS cant_incidentes_pend FROM mtoca_incidente WHERE cod_estadoincidente='001' 
                              AND DATEPART(yyyy,fch_reporte)='".$anio."'"
        ));

        $totproc  = DB::select(DB::raw("SELECT COUNT(cod_incidente) AS cant_incidentes_proc FROM mtoca_incidente WHERE cod_estadoincidente='002' 
                              AND DATEPART(yyyy,fch_reporte)='".$anio."'"
        ));

        $totatend = DB::select(DB::raw("SELECT COUNT(cod_incidente) AS cant_incidentes_cerr FROM mtoca_incidente WHERE cod_estadoincidente='003' 
                              AND DATEPART(yyyy,fch_reporte)='".$anio."'"
        ));

        $totcanc  = DB::select(DB::raw("SELECT COUNT(cod_incidente) AS cant_incidentes_cancel FROM mtoca_incidente WHERE cod_estadoincidente='004' 
                              AND DATEPART(yyyy,fch_reporte)='".$anio."'"
        ));

        $ctotalp  = $totalp[0]->cant_incidentes_pend;
        $ctotproc = $totproc[0]->cant_incidentes_proc;
        $ctotatend= $totatend[0]->cant_incidentes_cerr;
        $ctotcanc = $totcanc[0]->cant_incidentes_cancel;

        //
        $data = [];
        array_push($data, [
          [
            "value" => $ctotalp,
            "name" => "Pendiente"
          ],
          [
            "value" => $ctotproc,
            "name" => "En proceso"
          ],
          [
            "value" => $ctotatend,
            "name"  => "Atentido"
          ],
          [
            "value" => $ctotcanc,
            "name"  => "Cancelado"
          ]
          
        ]);

        //Construimos el json
        $title  = 'Estados de incidencia';
        $result = $this->successResponseData($title,$data);

        return $result;
        
      }catch(\Exception $e){
        return $this->errorResponse();   
      }
    }

    public function getIncidenciaAnio(Request $request){
      try{
        $anio = $request->year;
        $data = [];
        for($i=1;$i<=12;$i++){
          $total   = DB::select(DB::raw("SELECT COUNT(cod_incidente) AS total_incidentes FROM mtoca_incidente WHERE DATEPART(yyyy,fch_reporte)='".$anio."' 
                      AND DATEPART(MM,fch_reporte)='".$i."'"
                      ));
          $ctotal  = $total[0]->total_incidentes;

          //Lo vamos agregando al arreglo
          array_push($data, 
               $ctotal,
          );
        }

        //Construimos el json
        $title  = 'Total de incidencias';
        $result = $this->successResponseData($title,$data);

        return $result;

      }catch(\Exception $e){
        return $this->errorResponse();    
      }
      
    }

    public function getExportarIncidencia(Request $request){
      try{

        $fecha_act = Carbon::now('America/Lima'); 
        $anio      = $fecha_act->year;
        $mes       = $fecha_act->format('m');
        $dia       = $fecha_act->format('d');
        $fecha     = $dia.'-'.$mes.'-'.$anio;
        $name      = 'ReporteIncidencia';
        $reporte   = $name.'_'.$fecha.'.xlsx';

        $idstate   = $request->idstate;
        $search    = $request->search;
        $fdesde    = $request->fdesde;
        $fhasta    = $request->fhasta;
        $codresp   = $request->codresp;
        $codeinc   = $request->codincd;

      return Excel::download(new IncidenciaExport($idstate,$search,$fdesde,$fhasta,$codresp,$codeinc), $reporte);

      }catch(\Exception $e){
        DB::rollback();
        return $this->redirectToHome(); 
      }
    }

}

class IncidenciaHelper{

    public static function UltimoRegistro(){
        
        $fecha_act = Carbon::now('America/Lima'); 
        $anio      = Carbon::now()->year;
        $mes       = Carbon::now()->format('m'); 
        $fecha     = $anio.'-'.$mes; 
        $correlat  = '0000001';
        //armamos la cadena de SQL
        $sql       = DB::select(DB::raw("SELECT MAX(cod_incidente) as code FROM mtoca_incidente where cod_incidente like '%".$fecha."%'"));
        $cant      = sizeof($sql);
        $codigon   = $sql[0]->code;

        //$cadena    = 'Code:'.$codigon;

        if($codigon!='' || $codigon!=null){
          //Se trabaja con la cadena y se saca el ultimo
          $parte   = substr($codigon,8,7);
          //Se convierte a entero
          $ultimo  = (int)$parte;
          $sgte    = $ultimo + 1;
          $long    = strlen($sgte);

          switch ($long){
            case 1:
              $cad = '000000'.$sgte;
            break;
          
            case 2:
              $cad = '00000'.$sgte;
              break;
            
            case 3:
              $cad = '0000'.$sgte;
              break;
            
            case 4:
              $cad = '000'.$sgte;
              break;
            
            case 5:
              $cad = '00'.$sgte;
              break;
          
            case 6:
              $cad = '0'.$sgte;
            break;
          
            case 7:
              $cad = $sgte;
            break;
          }

          $codeincidencia = $fecha.'-'.$cad;

        }else{
          //Quiere decir que en el presente año y mes aun no hay registros, asi que se ingresa desde 00000001 // 2020-08-0000001
          $codeincidencia = $fecha.'-'.$correlat;
        }

        return $codeincidencia;
    }

    public function ObtenerCadena($codigon){

      //$codigon = '2020-08-0999999';
      $parte   = substr($codigon,8,7);

      //Se convierte a entero
      $ultimo  = (int)$parte;
      $sgte    = $ultimo + 1;
      $long    = strlen($sgte);

      switch ($long) {
        case 1:
        $cad = '000000'.$sgte;
        break;
      
        case 2:
          $cad = '00000'.$sgte;
          break;
        
        case 3:
          $cad = '0000'.$sgte;
          break;
        
        case 4:
          $cad = '000'.$sgte;
          break;
        
        case 5:
          $cad = '00'.$sgte;
          break;
      
        case 6:
        $cad = '0'.$sgte;
        break;
      
        case 7:
        $cad = $sgte;
        break;
      }

      return $cad;

    }
    
}