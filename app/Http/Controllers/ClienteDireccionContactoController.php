<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\ClienteDireccionContacto;
use Illuminate\Support\Facades\DB;


class ClienteDireccionContactoController extends Controller
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

    //-------------------- Filtrado de numerlo de linea por cliente ------------------------
    public function postBuscarContacto(Request $request){
        try{
            $codcli     = $request->codcli;
            $lstcto     = DB::table('vtade_cliente_direccion_contacto as clidircto')
                         ->select('clidircto.cod_contacto', 'clidircto.dsc_nombre','clidircto.dsc_apellidos')
                         ->where('clidircto.cod_cliente', '=', $codcli)
                         ->orderBy('clidircto.dsc_apellidos')
                         ->get();

            $html = '<option value="0">[seleccione contacto]</option>';

            foreach($lstcto as $contacto){
                $html .= '<option value="'.$contacto->cod_contacto.'">'.$contacto->dsc_nombre.', '.$contacto->dsc_apellidos.'</option>';
            }

            echo $html;

        }catch(\Exception $e){
           return $this->errorResponse(); 
        }
        
    }
}
