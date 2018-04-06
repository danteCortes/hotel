<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoPago;

class TipoPagoController extends Controller{
  
  public function inicio(){
    return view('tiposPago.inicio');
  }

  public function guardar(Request $request) {
    $this->validate($request, [
      'nombre'=>'required|max:255',
      'descripcion'=>'nullable|max:255'
    ]);
    $tipoPago = new TipoPago;
    $tipoPago->nombre = mb_strtoupper($request->nombre);
    $tipoPago->descripcion = mb_strtoupper($request->descripcion);
    $tipoPago->save();
  }

  public function todos(){
    return TipoPago::get();
  }

  public function buscar($id){
    return TipoPago::find($id);
  }

  public function modificar(Request $request, $id){
    $this->validate($request, [
      'nombre'=>'required|max:255',
      'descripcion'=>'nullable|max:255'
    ]);
    $tipoPago = TipoPago::find($id);
    $tipoPago->nombre = mb_strtoupper($request->nombre);
    $tipoPago->descripcion = mb_strtoupper($request->descripcion);
    $tipoPago->update();
  }

  public function eliminar($id){
    $tipoPago = TipoPago::find($id);
    $tipoPago->delete();
  }



}
