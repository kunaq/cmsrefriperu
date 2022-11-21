<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Iniciamos a hacer el Login:
Route::group(['middleware' => ['custom.guest']], function (){
  Route::get('/','Auth\LoginController@showLoginForm');
  Route::post('login', 'Auth\LoginController@login')->name('login');
  
});

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//--------------------------------------------------------------------

Route::group(['middleware' => 'autenticado'], function (){ 

	//Route::get('equipo', 'EquipoController@getIndexEquipo')->name('equipo');

  // Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/home','ClienteController@getClientePerfil');

  Route::prefix('ciclo')->group(function (){
	   Route::get('/', 'CicloController@getIndexCiclo');
     Route::get('procedure','CicloController@getProcedmiento');
	});

  Route::prefix('tipoequipo')->group(function (){
     Route::post('buscarsubtipo','TipoEquipoController@postBuscarSubtipo');
  });

  Route::prefix('equipo')->group(function (){
    Route::get('/','EquipoController@getIndexEquipo');
    Route::get('listar','EquipoController@getListadoEquipo');
    Route::get('listar2','EquipoController@getListadoEquipo2');
    Route::get('exportar', 'EquipoController@getExportarEquipo');
    Route::get('detalle/{id?}','EquipoController@getDetalleEquipo');
    Route::get('modalDetalle/{cod_equipo?}','EquipoController@getModalDetalleEquipo');
    Route::get('listaIntervencion/{cod_equipo?}','EquipoController@getListaIntervencion');
    //Route::get('listaSede/{cod_cliente?}','EquipoController@getSedeDetalleEquipo');
    Route::get('ubicaciones/{codCliente?}','EquipoUbicacionesController@getUbicacion');
    Route::get('ubicaciones2/{codCliente?}{numLinea?}{lineaSuperior?}','EquipoUbicacionesController@getUbicacion2');
    Route::get('ubicaciones3/{codCliente?}{numLinea?}{lineaSuperior?}','EquipoUbicacionesController@getUbicacion3');
    
  });

	Route::prefix('incidencia')->group(function (){
	  Route::get('/', 'IncidenciaController@getIndexIncidencia');
    Route::get('listar','IncidenciaController@getListadoIncidencia');
	  Route::get('crear', 'IncidenciaController@getCrearIncidencia');
    Route::post('crear','IncidenciaController@postCrearIncidencia')->name('incidencia.registro');
    Route::get('editar/{id}','IncidenciaController@getEditarIncidencia');
    Route::post('editar', 'IncidenciaController@postEditarIncidencia')->name('incidencia.editar');
    Route::get('eliminar', 'IncidenciaController@eliminarIncidente');
    Route::get('resumen', 'IncidenciaController@resumenIncidente');
    Route::get('exportar', 'IncidenciaController@getExportarIncidencia');

    //Graficos estadisticos
    Route::get('reporte/estados', 'IncidenciaController@getestadoIncidenciaAnio');
    Route::get('reporte/incidencia', 'IncidenciaController@getIncidenciaAnio');

	});

	Route::prefix('subtipo')->group(function (){
    Route::post('buscar','SubtipoIncidenteController@postBuscarSubtipoIncidente');
  });

  Route::prefix('clientedireccion')->group(function (){
    Route::post('numlinea','ClienteDireccionController@postBuscarNumLinea');
  });

  Route::prefix('clientedireccioncontacto')->group(function (){
    Route::post('contacto','ClienteDireccionContactoController@postBuscarContacto');
  });


  Route::group(['middleware' => 'role:Cliente'], function (){       //['middleware' => 'Rol']
    
    Route::prefix('cliente')->group(function (){
    Route::get('perfil','ClienteController@getClientePerfil')->name('home');
    Route::get('contactos','ClienteController@getContactoCliente');
    Route::get('centro_responsabilidad','ClienteController@getCentroResponsabilidadCliente');
    Route::get('direccion','ClienteController@getDireccionCliente');

    Route::get('direccion_contacto','ClienteController@getDireccionContactoCliente');
    Route::get('ubicacion','ClienteController@getUbicacionCliente');

    });


  });



});