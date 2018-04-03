<?php

namespace App\Http\Traits;

use App\Usuario;
use Hash;

class UsuarioTrait{
  
  static function guardar(array $datos){
    $usuario = new Usuario;
    $usuario->persona_dni = $datos['persona_dni'];
    $usuario->password = Hash::make($datos['persona_dni']);
    if ($datos['tipo']) {
      $usuario->tipo = $datos['tipo'];
    }
    $usuario->save();

    return $usuario;
  }
}
