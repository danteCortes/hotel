<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Huesped;
use Carbon\Carbon;

trait HuespedTrait{

  static function guardar(array $datos){

    $huesped = new Huesped;
    $huesped->persona_dni = $datos['persona_dni'];
    $huesped->habitacion_id = $datos['habitacion_id'];
    $huesped->inicio = $datos['inicio'];
    if ($datos['salida']) {
      $huesped->salida = Carbon::createFromFormat('d/m/Y', $datos['salida'])->format('Y-m-d');
    }
    $huesped->save();

    return $huesped;
  }

  static function modificar(Huesped $huesped, array $datos){

    if ($datos['salida']) {
      $huesped->salida = Carbon::createFromFormat('d/m/Y', $datos['salida'])->format('Y-m-d');
    }else{
      $huesped->salida = null;
    }
    $huesped->update();

    return $huesped;
  }



}

 ?>
