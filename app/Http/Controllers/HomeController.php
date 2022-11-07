<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Incidencia;
use App\Http\Controllers\IncidenciaController;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()  //Me valida si el usuario esta autenticado.
    {
        $this->middleware('autenticado');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
    */

    public function index(){

      $ctotal   = IncidenciaController::totalIncidencias();

      return view('pages.home',compact('ctotal'));

    }
}
