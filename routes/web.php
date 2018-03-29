<?php

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

Route::prefix('hotel')->group(function(){
  Route::get('/', 'HotelController@inicio');
  Route::prefix('huesped')->group(function(){
    Route::get('/{id}', 'HuespedController@buscar')->where('id', '[0-9]+');
    Route::post('/', 'HuespedController@guardar')->name('huesped');
    Route::put('/{id}', 'HuespedController@modificar')->where('id', '[0-9]+');
  });
  Route::prefix('habitacion')->group(function(){
    Route::get('/{id}', 'HabitacionController@buscar')->where('id', '[0-9]+');
  });
  Route::post('listar', 'HotelController@listar');
  Route::get('edificio/{id}', 'HotelController@edificio');
  Route::post('listar-edificio/{id}', 'HotelController@listarEdificio');
  Route::post('registrar/{id}', 'HotelController@registrar');
  Route::post('buscar-huesped', 'HotelController@buscarHuesped');
  Route::put('modificar-huesped/{id}', 'HotelController@modificarHuesped');
  Route::get('habitacion/{id}', 'HotelController@habitacion');
  Route::get('mostrar-deuda/{id}', 'HotelController@mostrarDeuda');
});

/* RUTAS PARA GESTIONAR LAS HABITACIONES */
Route::prefix('habitacion')->group(function(){
  Route::get('/', 'HabitacionController@inicio');
  Route::post('/', 'HabitacionController@guardar');
  Route::post('listar', 'HabitacionController@listar');
  Route::post('buscar', 'HabitacionController@buscar');
  Route::put('/{id}', 'HabitacionController@modificar');
  Route::delete('/{id}', 'HabitacionController@eliminar');
});

/* RUTAS PARA GESTIONAR LOS EDIFICIOS */
Route::prefix('edificio')->group(function(){
  Route::get('/', 'EdificioController@inicio');
  Route::post('/', 'EdificioController@guardar');
  Route::post('listar', 'EdificioController@listar');
  Route::post('buscar', 'EdificioController@buscar');
  Route::put('/{id}', 'EdificioController@modificar');
  Route::delete('/{id}', 'EdificioController@eliminar');
});




Route::get('/', 'LoginController@inicio');
Route::get('login', 'LoginController@frmInicioSesion');
Route::post('ingresar', 'LoginController@ingresar');
Route::get('verificar-tipo', 'LoginController@verificarTipo');
Route::get('salir', 'LoginController@salir');

Route::get('administrador', 'ConfiguracionController@administrador');
Route::get('cajero', 'ConfiguracionController@cajero');
Route::get('editar-usuario', 'ConfiguracionController@editarUsuario');
Route::post('cambiar-password', 'ConfiguracionController@cambiarPassword');

Route::resource('usuario', 'UsuarioController');
Route::post('restaurar-contrasenia', 'UsuarioController@restaurarContrasenia');
Route::post('abrir-caja', 'UsuarioController@abrirCaja');
Route::post('cerrar-caja', 'UsuarioController@cerrarCaja');
Route::get('caja-cerrada', 'UsuarioController@cajaCerrada');

// Registra al primer usuario de tipo administrador.
Route::post('primer-usuario', 'ConfiguracionController@primero');
