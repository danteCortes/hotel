<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Limpieza;
use Carbon\Carbon;

class LimpiezaController extends Controller{

  public function guardar(Request $request){
    $limpieza = new Limpieza;
    $limpieza->habitacion_id = $request->habitacion_id;
    $limpieza->fecha = Carbon::now()->format('Y-m-d H:i:s');
    $limpieza->save();

    return redirect()->back()->with('correcto', 'LA HABITACIÓN '.$limpieza->habitacion->numero.
    ' DEL EDIFICIO '.$limpieza->habitacion->edificio->nombre.' FUE LIMPIADO CON ÉXITO.');
    dd($request);
  }




    //
}
