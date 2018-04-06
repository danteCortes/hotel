<?php

namespace App\Http\Traits;

use App\Pago;

class PagoTrait{

  static function guardar(array $datos){

    $pago = new Pago;
    $pago->huesped_id = $datos['huesped_id'];
    $pago->tipo_pago_id = $datos['tipo_pago_id'];
    $pago->fecha = $datos['fecha'];
    $pago->monto = $datos['monto'];
    $pago->save();

    return $pago;
  }
  




}
