<?php

Route::prefix('hotel')->group(function(){
  Route::get('/', 'HotelController@inicio');
  Route::prefix('huesped')->group(function(){
    Route::put('/{id}', 'HuespedController@modificar')->where('id', '[0-9]+');
  });
  Route::prefix('habitacion')->group(function(){
    Route::get('/{id}', 'HabitacionController@buscar')->where('id', '[0-9]+');
  });
  Route::prefix('pago')->group(function(){
    Route::post('/', 'PagoController@guardar')->name('pago');
  });
  Route::prefix('limpieza')->group(function(){
    Route::post('/', 'LimpiezaController@guardar')->name('limpieza');
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


Route::get('salir', 'LoginController@salir');

Route::get('cajero', 'ConfiguracionController@cajero');
Route::get('editar-usuario', 'ConfiguracionController@editarUsuario');
Route::post('cambiar-password', 'ConfiguracionController@cambiarPassword');

Route::resource('usuario', 'UsuarioController');
Route::post('restaurar-contrasenia', 'UsuarioController@restaurarContrasenia');
Route::post('abrir-caja', 'UsuarioController@abrirCaja');
Route::post('cerrar-caja', 'UsuarioController@cerrarCaja');
Route::get('caja-cerrada', 'UsuarioController@cajaCerrada');

// Registra al primer usuario de tipo administrador.
Route::get('/', 'LoginController@inicio');
Route::prefix('login')->group(function(){
  Route::get('/', 'LoginController@frmInicioSesion');
  Route::post('primer-usuario', 'LoginController@primero')->name('primer-usuario');
  Route::post('ingresar', 'LoginController@ingresar')->name('ingresar');
  Route::get('verificar-tipo', 'LoginController@verificarTipo');
});

Route::prefix('administrador')->group(function(){
  Route::get('/', 'ConfiguracionController@administrador');
  Route::prefix('usuario')->group(function(){
    Route::get('/', 'UsuarioController@inicio');
  });
  Route::prefix('edificio')->group(function(){
    Route::get('/', 'EdificioController@inicio');
    Route::get('/todos', 'EdificioController@todos');
    Route::post('/', 'EdificioController@guardar')->name('edificio');
    Route::post('listar', 'EdificioController@listar');
    Route::get('/{id}', 'EdificioController@buscar')->where('id', '[0-9]+');
    Route::put('/{id}', 'EdificioController@modificar')->where('id', '[0-9]+');
    Route::delete('/{id}', 'EdificioController@eliminar')->where('id', '[0-9]+');
  });
  Route::prefix('habitacion')->group(function(){
    Route::get('/', 'HabitacionController@inicio');
    Route::get('/{id}', 'HabitacionController@buscar')->where('id', '[0-9]+');
    Route::get('/todos', 'HabitacionController@todos');
    Route::post('/', 'HabitacionController@guardar');
    Route::post('listar', 'HabitacionController@listar');
    Route::put('/{id}', 'HabitacionController@modificar')->where('id', '[0-9]+');
    Route::delete('/{id}', 'HabitacionController@eliminar')->where('id', '[0-9]+');
  });
  Route::prefix('huesped')->group(function(){
    Route::get('/{id}', 'HuespedController@buscar')->where('id', '[0-9]+');
    Route::post('/', 'HuespedController@guardar');
  });
  Route::prefix('tipo-pago')->group(function(){
    Route::get('/', 'TipoPagoController@inicio');
    Route::get('/todos', 'TipoPagoController@todos');
    Route::get('/{id}', 'TipoPagoController@buscar')->where('id', '[0-9]+');
    Route::post('/', 'TipoPagoController@guardar');
    Route::put('/{id}', 'TipoPagoController@modificar')->where('id', '[0-9]+');
    Route::delete('/{id}', 'TipoPagoController@eliminar')->where('id', '[0-9]+');
  });
  Route::prefix('persona')->group(function(){
    Route::get('/{dni}', 'PersonaController@buscar')->where('dni', '[0-9]+');
  });
});
