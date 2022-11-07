<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Helpers\AppHelper;

use Carbon\Carbon;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\TipoEquipo;
use App\Models\SubTipoEquipo;
use App\Models\Equipo;
use Illuminate\Support\Facades\DB;

//Libreria Excel
use App\Exports\EquipoExport;
use Maatwebsite\Excel\Facades\Excel;

class EquipoController extends Controller{
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


    public function getIndexEquipo(){

        $marcas  = DB::table('feima_marca_articulo as marca')
                   ->select('marca.cod_marca', 'marca.dsc_marca','marca.flg_activo')
                   ->get();

        $modelos = DB::table('feima_modelo_articulo as modelo')
                   ->select('modelo.cod_modelo','modelo.dsc_modelo','modelo.flg_activo')
                   ->get();

        $tipos   = DB::table('gsema_tipo_equipo as tipo')
                   ->select('tipo.cod_tipo_equipo','tipo.dsc_tipo_equipo','tipo.flg_activo')
                   ->get();

        $subtipos= DB::table('gsema_subtipo_equipo as subtipo')
                   ->select('subtipo.cod_subtipo_equipo','subtipo.dsc_subtipo_equipo','subtipo.flg_activo')
                   ->get();       

        return view('pages.equipo.index',compact('marcas','modelos','tipos','subtipos')); 
    }

    public function getListadoEquipo(Request $request){
        $numserie  = $request->numserie;
        $tipo      = $request->tipo;
        $subtipo   = $request->subtipo;
        $nomequipo = $request->nomequipo;
        $codmarca  = $request->codmarca;
        $codmodel  = $request->codmodel;

        //Se define la session del usuario
        $role      = Session()->get('rol');

        //Se hace la busqueda
        $equipos   = DB::table('gsema_equipo as equipo')
                     ->join('gsema_tipo_equipo','equipo.cod_tipo_equipo', '=', 'gsema_tipo_equipo.cod_tipo_equipo')
                     ->join('gsema_subtipo_equipo','equipo.cod_subtipo_equipo', '=', 'gsema_subtipo_equipo.cod_subtipo_equipo')
                     ->join('feima_marca_articulo','equipo.cod_marca', '=', 'feima_marca_articulo.cod_marca')
                     ->leftJoin('feima_modelo_articulo','equipo.cod_modelo', '=', 'feima_modelo_articulo.cod_modelo')
                     ->select('equipo.cod_equipo','equipo.dsc_equipo','equipo.cod_tipo_equipo','gsema_tipo_equipo.dsc_tipo_equipo',
                            'gsema_subtipo_equipo.dsc_subtipo_equipo','feima_marca_articulo.dsc_marca','feima_modelo_articulo.dsc_modelo','equipo.num_serie',
                            'equipo.num_parte','equipo.fch_compra','equipo.cod_proveedor','equipo.cod_cliente','equipo.num_pedido');

        $total    = $equipos->count();

        if (!empty($numserie))
            $equipos = $equipos->where('equipo.num_serie', 'like', '%' . $numserie . '%');

        if (!empty($tipo))
            $equipos = $equipos->where('equipo.cod_tipo_equipo', '=', $tipo);

        if (!empty($subtipo))
            $equipos = $equipos->where('equipo.cod_subtipo_equipo', '=', $subtipo);

        if (!empty($nomequipo))
            $equipos = $equipos->where('equipo.dsc_equipo', 'like', '%' . $nomequipo . '%');

        if (!empty($codmarca))
            $equipos = $equipos->where('equipo.cod_marca', '=', $codmarca);

        if (!empty($codmodel))
            $equipos = $equipos->where('equipo.cod_modelo', '=', $codmodel);

        //Hacemos la validacion aqui:
        if($role == config('constants.roles_name.cliente')){
          $codcli  = Session()->get('cod_cli');
          $equipos = $equipos->where('equipo.cod_cliente', '=', $codcli);
        }

        $filtrados = $equipos->count();

        $equipos   = $equipos
                    ->orderBy('equipo.dsc_equipo')
                    ->get();

        $data = [];
        foreach ($equipos as $item){
          
          if($item->dsc_modelo!=null){
            $model = $item->dsc_modelo;
          }else{
            $model = '';
          }

          array_push($data, [
            "code"        => $item->cod_equipo,
            "nombre"      => AppHelper::clientFormat($item->dsc_equipo),
            "idtipo"      => $item->cod_tipo_equipo,
            "nomtipo"     => $item->dsc_tipo_equipo,
            "nomsubtipo"  => $item->dsc_subtipo_equipo,
            "marca"       => $item->dsc_marca,
            "modelo"      => $model,
            "numserie"    => $item->num_serie,
            "numparte"    => $item->num_parte,
            "fechacompra" => $item->fch_compra,
            "numpedido"   => $item->num_pedido
          ]);
        }

        $result = $this->dataTableResult($total,$filtrados,$data);

        return $result;

    }

    public function getDetalleEquipo(Request $request){
        return view('pages.equipo.detalle');    
    }

    public function getExportarEquipo(Request $request){
        try{
            $fecha_act = Carbon::now('America/Lima'); 
            $anio      = $fecha_act->year;
            $mes       = $fecha_act->format('m');
            $dia       = $fecha_act->format('d');
            $fecha     = $dia.'-'.$mes.'-'.$anio;
            $name      = 'ReporteEquipo';
            $reporte   = $name.'_'.$fecha.'.xlsx';

            $numserie  = $request->numserie;
            $tipo      = $request->tipo;
            $subtipo   = $request->subtipo;
            $nomequipo = $request->nomequipo;
            $codmarca  = $request->codmarca;
            $codmodel  = $request->codmodel;

            return Excel::download(new EquipoExport($numserie,$tipo,$subtipo,$nomequipo,$codmarca,$codmodel), $reporte);

        }catch(\Exception $e){
            DB::rollback();
            return $this->redirectToHome();
        }
    }


}
