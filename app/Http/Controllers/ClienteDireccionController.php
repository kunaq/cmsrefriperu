<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\ClienteDireccion;
use Illuminate\Support\Facades\DB;


class ClienteDireccionController extends Controller
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
    public function postBuscarNumLinea(Request $request){
        try{
            $codcli     = $request->idcli;
            $lstnumline = DB::table('vtade_cliente_direccion as clidir')
                         ->select('clidir.num_linea', 'clidir.dsc_direccion')
                         ->where('clidir.cod_cliente', '=', $codcli)
                         ->orderBy('clidir.dsc_direccion')
                         ->get();

            $html = '<option value="0">[seleccione linea]</option>';

            foreach($lstnumline as $numlinea){
                $html .= '<option value="'.$numlinea->num_linea.'">'.$numlinea->dsc_direccion.'</option>';
            }

            echo $html;

        }catch(\Exception $e){
           echo 'error'; 
        }
        
    }
}
