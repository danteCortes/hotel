<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;
use Carbon\Carbon;

class PagoController extends Controller{

  public function guardar(Request $request){
    $this->validate($request, [
      'huesped_id'=>'required|exists:huespedes,id',
      'tipo_pago_id'=>'required|exists:tipos_pago,id',
      'monto'=>'required|numeric',
      'descripcion'=>'nullable'
    ]);
    
    $pago = new Pago;
    $pago->huesped_id = $request->huesped_id;
    $pago->tipo_pago_id = $request->tipo_pago_id;
    $pago->fecha = Carbon::now()->format('Y-m-d H:i:s');
    $pago->descripcion = mb_strtoupper($request->descripcion);
    $pago->monto = $request->monto;
    $pago->save();
  }
  




}
