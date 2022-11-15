<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\ClienteContacto;
use App\Models\ClienteCentroResponsabilidad;
use App\Models\ClienteDireccion;
use App\Models\ClienteDireccionContacto;
use App\Models\UbicacionDireccion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ClienteController extends Controller
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

    
    public function getClientePerfil(Request $request){

        $codcli  = $request->session()->get('cod_cli'); 
        $cliente = Cliente::where('cod_cliente', $codcli)->firstOrFail();
        $clientePlus = ClienteDireccionContacto::where('cod_cliente',$codcli)->firstOrFail();
        
        return view('pages.cliente.perfil',compact('cliente','codcli','clientePlus'));

    }

    public function getContactoCliente(Request $request){
        try{
            $codecli    = $request->codcli;

            $contactos  = DB::table('vtade_cliente_contacto as clientecontacto')
                          ->select('clientecontacto.cod_contacto', 'clientecontacto.dsc_nombre','clientecontacto.dsc_apellidos','clientecontacto.dsc_correo',
                             'clientecontacto.dsc_telefono1','clientecontacto.dsc_cargo','clientecontacto.fch_registro')
                          ->where('clientecontacto.cod_cliente', '=', $codecli )
                          ->orderBy('clientecontacto.dsc_apellidos')
                          ->get();

            $total     = $contactos->count();
            $filtrados = 0;
            $data      = [];
            foreach ($contactos as $item){
              array_push($data, [
                "cod_contacto"  => $item->cod_contacto,
                "nombre"        => $item->dsc_nombre,
                "apellidos"     => $item->dsc_apellidos,
                "correo"        => $item->dsc_correo,
                "telefono"      => $item->dsc_telefono1,
                "cargo"         => $item->dsc_cargo,
                "fech_reg"      => $item->fch_registro
              ]);
            }

            $result = $this->dataTableResult($total,$filtrados,$data);

            return $result;

        }catch(\Exception $e){
            return $this->emptyCustomDataTable();    
        }    
    }

    public function getCentroResponsabilidadCliente(Request $request){
        try{
            $codecli = $request->codecli;

            $centros = DB::table('vtade_cliente_centroresponsabilidad as clienteresponsable')
                          ->select('clienteresponsable.cod_centroresp', 'clienteresponsable.dsc_centroresp','clienteresponsable.flg_activo',
                                   'clienteresponsable.cod_centroresp_sup','clienteresponsable.cod_contacto')
                          ->where('clienteresponsable.cod_cliente', '=', $codecli )
                          ->orderBy('clienteresponsable.dsc_centroresp')
                          ->get();

            $total     = $centros->count();
            $filtrados = 0;
            $data      = [];
            foreach ($centros as $item){
              array_push($data, [
                "cod_centro"   => $item->cod_centroresp,
                "nom_centro"   => $item->dsc_centroresp,
                "estado"       => $item->flg_activo,
                "code_sup"     => $item->cod_centroresp_sup,
                "cod_contacto" => $item->cod_contacto
              ]);
            }

            $result = $this->dataTableResult($total,$filtrados,$data);

            return $result;

        }catch(\Exception $e){
            return $this->emptyCustomDataTable();    
        }    
    }

    public function getDireccionCliente(Request $request){
        try{
            $idcli       = $request->idcli;

            $direcciones = DB::table('vtade_cliente_direccion as clidir')
                          ->join('vtama_pais','clidir.cod_pais', '=', 'vtama_pais.cod_pais')
                          ->join('vtama_departamento','clidir.cod_departamento', '=', 'vtama_departamento.cod_departamento')
                          ->join('vtama_provincia','clidir.cod_provincia', '=', 'vtama_provincia.cod_provincia')
                          ->join('vtama_distrito','clidir.cod_distrito', '=', 'vtama_distrito.cod_distrito')
                          ->select('clidir.cod_cliente','clidir.num_linea', 'clidir.dsc_direccion','clidir.dsc_referencia','vtama_pais.dsc_pais as pais',
                                   'vtama_departamento.dsc_departamento as departamento','vtama_provincia.dsc_provincia as provincia',
                                   'vtama_distrito.dsc_distrito as distrito','clidir.cod_tipo_direccion','clidir.dsc_telefono_1')
                          ->where('clidir.cod_cliente', '=', $idcli )
                          ->orderBy('clidir.dsc_direccion')
                          ->get();

            $total       = $direcciones->count();
            $filtrados   = 0;
            $data        = [];
            foreach ($direcciones as $item){
              array_push($data, [
                "codcliente"   => $item->cod_cliente,
                "numlinea"     => $item->num_linea,
                "direccion"    => $item->dsc_direccion,
                "referencia"   => $item->dsc_referencia,
                "pais"         => $item->pais,
                "departamento" => $item->departamento,
                "provincia"    => $item->provincia,
                "distrito"     => $item->distrito,
                "codtipodir"   => $item->cod_tipo_direccion,
                "telefono"     => $item->dsc_telefono_1
              ]);
            }

            $result = $this->dataTableResult($total,$filtrados,$data);

            return $result;

        }catch(Request $request){
            return $this->emptyCustomDataTable();
        }
    }

    public function getDireccionContactoCliente(Request $request){
        try{
            $idcli  = $request->codecli;
            $idline = $request->codelinea;

            $dircontactos = DB::table('vtade_cliente_direccion_contacto as clidircto')
                            ->select('clidircto.dsc_nombre','clidircto.dsc_apellidos', 'clidircto.dsc_correo','clidircto.dsc_telefono1','clidircto.dsc_cargo',
                                     'clidircto.cod_usuario_web')
                            ->where('clidircto.cod_cliente', '=', $idcli )
                            ->where('clidircto.num_linea', '=', $idline )
                            ->orderBy('clidircto.dsc_apellidos')
                            ->get();

            $total       = $dircontactos->count();
            $filtrados   = 0;
            $data        = [];
            foreach ($dircontactos as $item){
              array_push($data, [
                "name"       => $item->dsc_nombre,
                "firstname"  => $item->dsc_apellidos,
                "email"      => $item->dsc_correo,
                "phone"      => $item->dsc_telefono1,
                "cargo"      => $item->dsc_cargo,
                "usuario"    => $item->cod_usuario_web
              ]);
            }

            $result = $this->dataTableResult($total,$filtrados,$data);

            return $result;

        }catch(Request $request){
            return $this->emptyCustomDataTable();    
        }    
    }

    public function getUbicacionCliente(Request $request){
        try{
            $idcli   = $request->codecli;
            $idline  = $request->codelinea;

            $query   = DB::table('mtoma_ubicacion as ubicacion')
                       ->select('ubicacion.cod_ubicacion','ubicacion.dsc_ubicacion', 'ubicacion.cod_nivel','ubicacion.cod_ubicacion_sup',
                               'ubicacion.flg_activo','ubicacion.cod_cliente','ubicacion.cod_contacto')
                       ->where([
                          ['ubicacion.cod_cliente', '=', $idcli],
                          ['ubicacion.num_linea', '=', $idline]
                       ])
                       ->orderBy('ubicacion.dsc_ubicacion')
                       ->get();

            $total       = $query->count();    //dd($query->toSql());
            $filtrados   = 0;
            $data        = [];

            foreach ($query as $item){
              $codecli = $item->cod_cliente;
              $codecto = $item->cod_contacto;
              //Hacemos la consulta
              if($codecto!=null){
                $contacto = DB::table('vtade_cliente_direccion_contacto as clidir')   
                            ->select('clidir.cod_cliente', 'clidir.dsc_nombre','clidir.dsc_apellidos')
                            ->where([
                              ['clidir.cod_contacto', '=', $codecto],
                              ['clidir.cod_cliente', '=', $codecli]
                            ])
                            ->get()[0];

                $namecto = $contacto->dsc_nombre;
                $apecto  = $contacto->dsc_apellidos;

                $nombres = $namecto.', '.$apecto;

              }else{
                $nombres = 'Sin responsable';
              }

              array_push($data, [
                "codigo"      => $item->cod_ubicacion,
                "ubicacion"   => $item->dsc_ubicacion,
                "codnivel"    => $item->cod_nivel,
                "codubsup"    => $item->cod_ubicacion_sup,
                "estado"      => $item->flg_activo,
                "codcli"      => $item->cod_cliente,
                "codcontacto" => $item->cod_contacto,
                "nombres"     => $nombres
                //"apellidos"   => $item->dsc_apellidos
              ]);
            }

            $result = $this->dataTableResult($total,$filtrados,$data);

            return $result;

        }catch(Request $request){
          return $this->emptyCustomDataTable();  
        }    
    }

}