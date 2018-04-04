<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Habitacion;
use Validator;

class HabitacionController extends Controller{

  public function inicio(){
    return view('habitaciones.inicio');
  }

  public function guardar(Request $request){
    $this->validate($request, [
      'edificio_id'=>'required|exists:edificios,id',
      'numero'=>'required|integer',
      'precio'=>'required|numeric',
      'piso'=>'required|integer',
      'televisor'=>'nullable'
    ]);
    $habitacion = new Habitacion;
    $habitacion->numero = $request->numero;
    $habitacion->piso = $request->piso;
    $habitacion->televisor = mb_strtoupper($request->televisor);
    $habitacion->precio = str_replace(' ', '', $request->precio);
    $habitacion->edificio_id = $request->edificio_id;
    $habitacion->save();
  }

  public function listar(Request $request){
    $line_quantity = intVal($request->current);
    $line_number = intVal($request->rowCount);
    $where = $request->searchPhrase;
    $sort = $request->sort;

    if (isset($sort['numero'])) {
        $order_by = 'numero';
        $order_name = $sort['numero'];
    }
    if (isset($sort['edificio'])) {
        $order_by = 'edificio';
        $order_name = $sort['edificio'];
    }
    if (isset($sort['piso'])) {
        $order_by = 'piso';
        $order_name = $sort['piso'];
    }
    if (isset($sort['televisor'])) {
        $order_by = 'televisor';
        $order_name = $sort['televisor'];
    }
    if (isset($sort['precio'])) {
        $order_by = 'precio';
        $order_name = $sort['precio'];
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
        $habitaciones = \DB::table('habitaciones')
          ->join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->select(
            'habitaciones.id as id',
            'habitaciones.numero as numero',
            'habitaciones.televisor as televisor',
            'edificios.nombre as edificio',
            'habitaciones.piso as piso',
            'habitaciones.precio as precio'
          )
          ->distinct()
          ->offset($skip)
          ->limit($take)
          ->orderBy($order_by, $order_name)
          ->get();
      } else {
        $habitaciones = \DB::table('habitaciones')
          ->join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->where('habitaciones.numero', 'like', '%'.$where.'%')
          ->orWhere('edificios.nombre', 'like', '%'.$where.'%')
          ->orWhere('habitaciones.piso', 'like', '%'.$where.'%')
          ->orWhere('habitaciones.televisor', 'like', '%'.$where.'%')
          ->orWhere('habitaciones.precio', 'like', '%'.$where.'%')
          ->select(
            'habitaciones.id as id',
            'habitaciones.numero as numero',
            'habitaciones.televisor as televisor',
            'edificios.nombre as edificio',
            'habitaciones.piso as piso',
            'habitaciones.precio as precio'
          )
          ->distinct()
          ->offset($skip)
          ->limit($take)
          ->orderBy($order_by, $order_name)
          ->get();
      }

      if (empty($where)) {
        $total = \DB::table('habitaciones')
          ->join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->distinct()
          ->get();

        $total = count($total);
      } else {
        $total = \DB::table('habitaciones')
          ->join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->where('habitaciones.numero', 'like', '%'.$where.'%')
          ->orWhere('edificios.nombre', 'like', '%'.$where.'%')
          ->orWhere('habitaciones.piso', 'like', '%'.$where.'%')
          ->orWhere('habitaciones.precio', 'like', '%'.$where.'%')
          ->orWhere('habitaciones.televisor', 'like', '%'.$where.'%')
          ->distinct()
          ->get();

        $total = count($total);
      }
    }

    $datas = [];
    $cantidad = 0;
    foreach ($habitaciones as $habitacion):
      $data = array_merge(
        array
        (
          "id" => $habitacion->id,
          "numero" => $habitacion->numero,
          "edificio" => $habitacion->edificio,
          "piso"=>$habitacion->piso,
          "televisor"=>$habitacion->televisor,
          "precio"=>number_format($habitacion->precio, 2, '.', ' ')
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

  public function buscar($id){
    return Habitacion::with('edificio')->where('id', $id)->first();
  }

  public function modificar(Request $request, $id){
    $this->validate($request, [
      'edificio_id'=>'required|exists:edificios,id',
      'numero'=>'required|integer',
      'precio'=>'required|numeric',
      'piso'=>'required|integer',
      'televisor'=>'nullable'
    ]);
    $habitacion = Habitacion::find($id);
    $habitacion->numero = $request->numero;
    $habitacion->piso = $request->piso;
    $habitacion->televisor = mb_strtoupper($request->televisor);
    $habitacion->precio = str_replace(' ', '', $request->precio);
    $habitacion->edificio_id = $request->edificio_id;
    $habitacion->save();
  }

  public function eliminar($id){
    $habitacion = \App\Habitacion::find($id);
    $habitacion->delete();
  }

}
