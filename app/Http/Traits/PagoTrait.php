<?php

namespace App\Http\Traits;

use App\Pago;

class PagoTrait{

  static function guardar(array $datos){

    $pago = new Pago;
    $pago->huesped_id = $datos['huesped_id'];
    $pago->fecha = $datos['fecha'];
    $pago->concepto = $datos['concepto'];
    $pago->monto = $datos['monto'];
    $pago->save();

    return $pago;
  }
  




}
