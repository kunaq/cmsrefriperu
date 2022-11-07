<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleHelper;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function errorResponse(){
        return response()->json([
            "status" => config('constants.status.error'),
            "title" => "Ocurrio un error",
            "text" => "Intentelo de nuevo o compruebe su conexión a Internet"
        ]);
    }

    protected function redirectToHome(){

        Alert()->error('Intentelo de nuevo o compruebe su conexión a Internet', 'Ocurrio un error')->persistent('Aceptar');

        $view = RoleHelper::hasAnyRole('Cliente|Trabajador') ? '/' : 'home';

        return redirect($view);
    }

    protected function successResponseData($title,$data){
        return response()->json([
            "title" => $title,
            "data" => $data
        ]);
    }

    protected function emptyCustomDataTable(){
        return response()->json([
            "status" => "Ocurrio un error",
            "data" => ['items' => []]
        ]);
    }

    protected function emptyDataTable(){
        return $this->dataTableFormat(0, 0, 0, []);
    }

    protected function dataTableResult($total, $filtered, $data){
        return [
            "total" => $total,
            "filtered" => $filtered,
            "items" => $data
        ];
    }

    protected function successAlert($text, $title){
        Alert()->success($text, $title)->persistent('Aceptar');
    }

    protected function infoAlert($text, $title = "No es posible realizar la acción"){
        Alert()->info($text, $title)->persistent('Aceptar');
    }

    protected function advertenciaAlert($text, $title="¡Advertencia!"){
        Alert()->warning($text, $title)->persistent('Cerrar');
    }

    protected function errorAlert($text, $title = "!Error¡"){
        Alert()->error($text, $title)->persistent('Aceptar');
    }

    protected function cleanString($cadena){
        return $cadena == null ? "" : preg_replace("/[^a-zA-Z0-9]+/", " ", trim($cadena));
    }

    

}
