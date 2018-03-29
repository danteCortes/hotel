<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Persona;

trait PersonaTrait{

  static function guardar(array $datos){

    $persona = new Persona;
    $persona->dni = $datos['dni'];
    $persona->nombres = mb_strtoupper($datos['nombres']);
    $persona->apellidos = mb_strtoupper($datos['apellidos']);
    $persona->direccion = mb_strtoupper($datos['direccion']);
    $persona->telefono = $datos['telefono'];
    $persona->save();

    return $persona;
  }

  static function modificar(Persona $persona, array $datos){

    $persona->dni = $datos['dni'];
    $persona->nombres = mb_strtoupper($datos['nombres']);
    $persona->apellidos = mb_strtoupper($datos['apellidos']);
    $persona->direccion = mb_strtoupper($datos['direccion']);
    $persona->telefono = $datos['telefono'];
    $persona->save();

    return $persona;
  }



}

 ?>
