<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\PersonaTrait;
use App\Habitacion;
use App\Huesped;
use Carbon\Carbon;

class HotelController extends Controller{

  use PersonaTrait;

  public function inicio(){
    return view('hotel.inicio');
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
    if (isset($sort['huesped'])) {
      $order_by = 'huesped';
      $order_name = $sort['huesped'];
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
        $habitaciones = \App\Habitacion::join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->leftJoin('huespedes', 'huespedes.habitacion_id', '=', 'habitaciones.id')
          ->leftJoin('personas', 'personas.id', '=', 'huespedes.persona_id')
          ->leftJoin('limpiezas', 'limpiezas.habitacion_id', '=', 'habitaciones.id')
          ->where(function($consulta){
            $consulta->where('huespedes.salida', null)
            ->orWhere(\DB::raw('date(huespedes.salida)'), '>=', \Carbon\Carbon::now()->format('Y-m-d'));
          })
          ->orWhere(function($consulta){
            $consulta->orWhereDate('limpiezas.fecha', '=', Carbon::now()->format('Y-m-d'));
          })
          ->select(
            'habitaciones.id as id',
            'habitaciones.numero as numero',
            'edificios.nombre as edificio',
            \DB::raw("concat(personas.nombres, ' ', personas.apellidos) as huesped"),
            'habitaciones.precio as precio',
            'habitaciones.televisor as televisor',
            'huespedes.salida as salida',
            'huespedes.id as huesped_id'
            )
          ->distinct()
          ->offset($skip)
          ->limit($take)
          ->orderBy($order_by, $order_name)
          ->get();
      } else {
        $habitaciones = \App\Habitacion::join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->leftJoin('huespedes', 'huespedes.habitacion_id', '=', 'habitaciones.id')
          ->leftJoin('personas', 'personas.id', '=', 'huespedes.persona_id')
          ->where(function($query) use ($where){
            $query->where('huespedes.salida', null)
            ->orWhere(\DB::raw('date(huespedes.salida)'), '>=', \Carbon\Carbon::now()->format('Y-m-d'));
          })
          ->where(function($query) use ($where){
            $query->where('habitaciones.numero', 'like', '%'.$where.'%')
            ->orWhere('edificios.nombre', 'like', '%'.$where.'%')
            ->orWhere(\DB::raw("concat(personas.nombres, ' ', personas.apellidos)"), 'like', '%'.$where.'%')
            ->orWhere('habitaciones.precio', 'like', '%'.$where.'%')
            ->orWhere('habitaciones.televisor', 'like', '%'.$where.'%');
          })
          ->select(
            'habitaciones.id as id',
            'habitaciones.numero as numero',
            'edificios.nombre as edificio',
            \DB::raw("concat(personas.nombres, ' ', personas.apellidos) as huesped"),
            'habitaciones.precio as precio',
            'habitaciones.televisor as televisor',
            'huespedes.salida as salida',
            'huespedes.id as huesped_id'
          )
          ->distinct()
          ->offset($skip)
          ->limit($take)
          ->orderBy($order_by, $order_name)
          ->get();
      }

      if (empty($where)) {
        $total = \App\Habitacion::join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->leftJoin('huespedes', 'huespedes.habitacion_id', '=', 'habitaciones.id')
          ->leftJoin('personas', 'personas.id', '=', 'huespedes.persona_id')
          ->where('huespedes.salida', null)
          ->orWhere(\DB::raw('date(huespedes.salida)'), '>=', \Carbon\Carbon::now()->format('Y-m-d'))
          ->distinct()
          ->get();

        $total = count($total);
      } else {
        $total = \App\Habitacion::join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->leftJoin('huespedes', 'huespedes.habitacion_id', '=', 'habitaciones.id')
          ->leftJoin('personas', 'personas.id', '=', 'huespedes.persona_id')
          ->where(function($query) use ($where){
            $query->where('huespedes.salida', null)
            ->orWhere(\DB::raw('date(huespedes.salida)'), '>=', \Carbon\Carbon::now()->format('Y-m-d'));
          })
          ->where(function($query) use ($where){
            $query->where('habitaciones.numero', 'like', '%'.$where.'%')
            ->orWhere('edificios.nombre', 'like', '%'.$where.'%')
            ->orWhere(\DB::raw("concat(personas.nombres, ' ', personas.apellidos)"), 'like', '%'.$where.'%')
            ->orWhere('habitaciones.precio', 'like', '%'.$where.'%')
            ->orWhere('habitaciones.televisor', 'like', '%'.$where.'%');
          })
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
          "huesped"=>$habitacion->huesped,
          "precio"=>number_format($habitacion->precio, 2, '.', ' '),
          "televisor"=>$habitacion->televisor,
          "salida"=>$habitacion->salida,
          "huesped_id"=>$habitacion->huesped_id
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

  public function edificio($id){
    $edificio = \App\Edificio::find($id);
    return view('hotel.edificios.inicio')->with('edificio', $edificio);
  }

  public function listarEdificio(Request $request, $id){
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
    if (isset($sort['huesped'])) {
      $order_by = 'huesped';
      $order_name = $sort['huesped'];
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
        $habitaciones = \App\Habitacion::join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->leftJoin('huespedes', 'huespedes.habitacion_id', '=', 'habitaciones.id')
          ->leftJoin('personas', 'personas.id', '=', 'huespedes.persona_id')
          ->where('habitaciones.edificio_id', $id)
          ->where(function($query){
            $query->where('huespedes.salida', null)
            ->orWhere(\DB::raw('date(huespedes.salida)'), '>=', \Carbon\Carbon::now()->format('Y-m-d'));
          })
          ->select(
            'habitaciones.id as id',
            'habitaciones.numero as numero',
            'edificios.nombre as edificio',
            \DB::raw("concat(personas.nombres, ' ', personas.apellidos) as huesped"),
            'habitaciones.precio as precio',
            'habitaciones.televisor as televisor',
            'huespedes.salida as salida'
            )
          ->distinct()
          ->offset($skip)
          ->limit($take)
          ->orderBy($order_by, $order_name)
          ->get();
      } else {
        $habitaciones = \App\Habitacion::join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->leftJoin('huespedes', 'huespedes.habitacion_id', '=', 'habitaciones.id')
          ->leftJoin('personas', 'personas.id', '=', 'huespedes.persona_id')
          ->where('habitaciones.edificio_id', $id)
          ->where(function($query){
            $query->where('huespedes.salida', null)
            ->orWhere(\DB::raw('date(huespedes.salida)'), '>=', \Carbon\Carbon::now()->format('Y-m-d'));
          })
          ->where(function($query) use ($where){
            $query->where('habitaciones.numero', 'like', '%'.$where.'%')
            ->orWhere('edificios.nombre', 'like', '%'.$where.'%')
            ->orWhere(\DB::raw("concat(personas.nombres, ' ', personas.apellidos)"), 'like', '%'.$where.'%')
            ->orWhere('habitaciones.precio', 'like', '%'.$where.'%')
            ->orWhere('habitaciones.televisor', 'like', '%'.$where.'%');
          })
          ->select(
            'habitaciones.id as id',
            'habitaciones.numero as numero',
            'edificios.nombre as edificio',
            \DB::raw("concat(personas.nombres, ' ', personas.apellidos) as huesped"),
            'habitaciones.precio as precio',
            'habitaciones.televisor as televisor'
          )
          ->distinct()
          ->offset($skip)
          ->limit($take)
          ->orderBy($order_by, $order_name)
          ->get();
      }

      if (empty($where)) {
        $total = \App\Habitacion::join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->leftJoin('huespedes', 'huespedes.habitacion_id', '=', 'habitaciones.id')
          ->leftJoin('personas', 'personas.id', '=', 'huespedes.persona_id')
          ->where('habitaciones.edificio_id', $id)
          ->where(function($query){
            $query->where('huespedes.salida', null)
            ->orWhere(\DB::raw('date(huespedes.salida)'), '>=', \Carbon\Carbon::now()->format('Y-m-d'));
          })
          ->distinct()
          ->get();

        $total = count($total);
      } else {
        $total = \App\Habitacion::join('edificios', 'edificios.id', '=', 'habitaciones.edificio_id')
          ->leftJoin('huespedes', 'huespedes.habitacion_id', '=', 'habitaciones.id')
          ->leftJoin('personas', 'personas.id', '=', 'huespedes.persona_id')
          ->where('habitaciones.edificio_id', $id)
          ->where(function($query){
            $query->where('huespedes.salida', null)
            ->orWhere(\DB::raw('date(huespedes.salida)'), '>=', \Carbon\Carbon::now()->format('Y-m-d'));
          })
          ->where(function($query) use ($where){
            $query->where('habitaciones.numero', 'like', '%'.$where.'%')
            ->orWhere('edificios.nombre', 'like', '%'.$where.'%')
            ->orWhere(\DB::raw("concat(personas.nombres, ' ', personas.apellidos)"), 'like', '%'.$where.'%')
            ->orWhere('habitaciones.precio', 'like', '%'.$where.'%')
            ->orWhere('habitaciones.televisor', 'like', '%'.$where.'%');
          })
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
          "huesped"=>$habitacion->huesped,
          "precio"=>number_format($habitacion->precio, 2, '.', ' '),
          "televisor"=>$habitacion->televisor,
          "salida"=>$habitacion->salida
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

  public function registrar(Request $request, $id){
    $habitacion = \App\Habitacion::find($id);
    $datosPersona = ['dni'=>$request->dni, 'nombres'=>$request->nombres, 'apellidos'=>$request->apellidos,
    'direccion'=>$request->direccion, 'telefono'=>$request->telefono];
    if ($persona = \App\Persona::where('dni', $request->dni)->first()) {
      $persona = $this->actualizarPersona($persona, $datosPersona);
    }else{
      $persona = $this->guardarPersona($datosPersona);
    }
    $huesped = new \App\Huesped;
    $huesped->persona_id = $persona->id;
    $huesped->habitacion_id = $habitacion->id;
    $huesped->inicio = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
    $huesped->salida = $request->salida;
    $huesped->save();

    $pago = new \App\Pago;
    $pago->huesped_id = $huesped->id;
    $pago->fecha = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
    $pago->concepto = mb_strtoupper('INGRESO AL HOTEL');
    $pago->monto = $habitacion->precio;
    $pago->save();
    
    return redirect('hotel')->with('EL HUESPED SE REGISTRÓ CORRECTAMENTE EN LA HABITACIÓN '.$habitacion->numero);
  }

  public function buscarHuesped(Request $request){
    $habitacion = \App\Habitacion::find($request->id);
    $huesped = \App\Huesped::where('habitacion_id', $request->id)->where(function($query){
      $query->where('salida', null)->orWhereDate(\DB::raw("date(salida)"), '>=', \Carbon\Carbon::now()
        ->format('Y-m-d'));
    })->first();
    if ($persona = \App\Persona::find($huesped->persona_id)) {
      return [$habitacion, $persona, $huesped, $habitacion->edificio];
    }
    return $huesped;

  }

  public function modificarHuesped(Request $request, $id){
    $huesped = \App\Huesped::where('habitacion_id', $id)
      ->latest('inicio')
      ->first();
    $persona = $huesped->persona;
    if ($request->dni != $persona->dni) {
      if (\App\Persona::where('dni', $request->dni)->first()) {
        return redirect('hotel')->with('error', 'EL DNI '.$request->dni.' ESTÁ REGISTRADO EN OTRO HUESPED.');
      }
    }
    $datosPersona = ['dni'=>$request->dni, 'nombres'=>$request->nombres, 'apellidos'=>$request->apellidos,
    'direccion'=>$request->direccion, 'telefono'=>$request->telefono];
    $persona = $this->actualizarPersona($persona, $datosPersona);

    $huesped->salida = $request->salida;
    $huesped->save();

    return redirect('hotel')->with('correcto', 'EL HUESPED FUE ACTUALIZADO CON ÉXITO.');
  }

  public function habitacion($id){
    return Habitacion::with('huespedes')->with('edificio')->where('id', $id)->first();
  }

  public function mostrarDeuda($id){
    $huesped = Huesped::where('habitacion_id', $id)->latest('inicio')->first();
    return $huesped;
  }

}
