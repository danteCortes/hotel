<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Edificio;

class EdificioController extends Controller{

  public function inicio(){
    return view('edificios.inicio.inicio');
  }

  public function guardar(Request $request){
    $edificio = new \App\Edificio;
    $edificio->nombre = mb_strtoupper($request->nombre);
    $edificio->ubicacion = mb_strtoupper($request->ubicacion);
    $edificio->save();
  }

  public function listar(Request $request){
    $line_quantity = intVal($request->current);
    $line_number = intVal($request->rowCount);
    $where = $request->searchPhrase;
    $sort = $request->sort;

    if (isset($sort['id'])) {
        $order_by = 'id';
        $order_name = $sort['id'];
    }
    if (isset($sort['nombre'])) {
        $order_by = 'nombre';
        $order_name = $sort['nombre'];
    }
    if (isset($sort['ubicacion'])) {
        $order_by = 'ubicacion';
        $order_name = $sort['ubicacion'];
    }

    $skip = 0;
    $take = $line_number;

    if ($line_quantity > 1) {
        //DESDE QUE REGISTRO SE INICIA
        $skip = $line_number * ($line_quantity - 1);
        //CANTIDAD DE RANGO
        $take = $line_number;
    }
    //Grupo de datos que enviaremos al modelo para filtrar
    if ($request->rowCount < 0) {

    } else {
      if (empty($where)) {
        $edificios = \DB::table('edificios')
          ->select(
            'edificios.id as id',
            'edificios.nombre as nombre',
            'edificios.ubicacion as ubicacion'
          )
          ->distinct()
          ->offset($skip)
          ->limit($take)
          ->orderBy($order_by, $order_name)
          ->get();
      } else {
        $edificios = \DB::table('edificios')
          ->where('edificios.nombre', 'like', '%'.$where.'%')
          ->where('edificios.ubicacion', 'like', '%'.$where.'%')
          ->select(
            'edificios.id as id',
            'edificios.nombre as nombre',
            'edificios.ubicacion as ubicacion'
          )
          ->distinct()
          ->offset($skip)
          ->limit($take)
          ->orderBy($order_by, $order_name)
          ->get();
      }

      if (empty($where)) {
        $total = \DB::table('edificios')
          ->distinct()
          ->get();

        $total = count($total);
      } else {
        $total = \DB::table('edificios')
          ->where('edificios.nombre', 'like', '%'.$where.'%')
          ->where('edificios.ubicacion', 'like', '%'.$where.'%')
          ->distinct()
          ->get();

        $total = count($total);
      }
    }

    $datas = [];
    $cantidad = 0;
    foreach ($edificios as $edificio):
      $data = array_merge(
        array
        (
          "id" => $edificio->id,
          "nombre" => $edificio->nombre,
          "ubicacion" => $edificio->ubicacion
        )
      );
      //Asignamos un grupo de datos al array datas
      $datas[] = $data;
    endforeach;

    return response()->json(
      array(
        'current' => $line_quantity,
        'rowCount' => $line_number,
        'rows' => $datas,
        'total' => $total,
        'skip' => $skip,
        'take' => $take
      )
    );

  }

  public function buscar(Request $request){
    $edificio = \App\Edificio::find($request->id);
    return $edificio;
  }

  public function modificar(Request $request, $id){
    $edificio = \App\Edificio::find($id);
    $edificio->nombre = mb_strtoupper($request->nombre);
    $edificio->ubicacion = mb_strtoupper($request->ubicacion);
    $edificio->save();
  }

  public function eliminar($id){
    $edificio = \App\Edificio::find($id);
    $edificio->delete();
  }

  public function todos(){
    return Edificio::with('habitaciones')->get();
  }


}
