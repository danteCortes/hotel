<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\PersonaTrait;
use App\Http\Traits\UsuarioTrait;
use App\Persona;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller{

  //use AuthenticatesUsers;

  public function inicio(){
    if (Auth::check()) {
      return redirect('verificar-tipo');
    }else {
      return redirect('login');
    }
  }

  public function frmInicioSesion(){
    return view('login.login');
  }

  public function primero(Request $request){

    $datosPersona = ['dni'=>$request->dni, 'nombres'=>$request->nombres, 'apellidos'=>$request->apellidos,
      'direccion'=>'', 'telefono'=>''];
    if (!$persona = Persona::where('dni', $request->dni)->first()) {
      $persona = PersonaTrait::guardar($datosPersona);
    }

    $datosUsuario = ['persona_dni'=>$persona->dni, 'tipo'=>1];
    $usuario = UsuarioTrait::guardar($datosUsuario);

    return redirect('login')->with('correcto', 'AHORA PUEDE INGRESAR AL SISTEMA CON SU DNI');
  }

  public function ingresar(Request $request){

    Validator::make($request->all(), [
      'dni' => 'required|exists:usuarios,persona_dni|digits:8',
      'password' => 'required',
    ])->validate();

    if (Auth::attempt(['persona_dni' => $request->dni, 'password' => $request->password], $request->recordarme)) {
      return redirect('login/verificar-tipo');
    }

    return redirect('login')->with('error', 'EL PASSWORD ES INCORRECTO, VUELVA A INTENTARLO');
  }

  public function verificarTipo(){
    if (Auth::check()) {

      if (Auth::user()->tipo == 1) {

        return redirect('administrador');
      } elseif (Auth::user()->tipo == 2) {

        return redirect('cajero');
      }
    }

    return redirect('login');
  }

  public function salir(){

    if (Auth::check()) {
      Auth::logout();
      return redirect('login')->with('correcto', 'SALIÓ DEL SISTEMA SATISFACTORIAMENTE.');
    }
    return redirect('login')->with('error', 'DEBE HABER INICIADO SESIÓN PRIMERO.');
  }
}
