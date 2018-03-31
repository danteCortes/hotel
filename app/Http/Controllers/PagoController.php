<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;
use Carbon\Carbon;

class PagoController extends Controller{

  public function guardar(Request $request){
    $pago = new Pago;
    $pago->huesped_id = $request->huesped_id;
    $pago->fecha = Carbon::now()->format('Y-m-d H:i:s');
    $pago->concepto = mb_strtoupper($request->concepto);
    $pago->monto = $request->pago;
    $pago->save();

    return redirect()->back()->with('correcto', 'EL PAGO DEL HUESPED '.$pago->huesped->persona->nombres.
    ' '.$pago->huesped->persona->apellidos.' FUE REGISTRADO CON ÉXITO');
    dd($request);
  }
  




}
