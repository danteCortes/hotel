@extends('plantillas.administrador')

@section('estilos')
{{Html::style('bootgrid/jquery.bootgrid.min.css')}}
@stop

@section('titulo')
  Habitaciones
  @include('habitaciones.nuevo.frmNuevo')
@stop

@section('contenido')
  @include('plantillas.mensajes')
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
      <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered" id="tblHabitaciones">
          <thead>
            <tr class="info">
              <th data-column-id="numero"  data-order="asc">Numero</th>
              <th data-column-id="edificio">Edificio</th>
              <th data-column-id="piso">Piso</th>
              <th data-column-id="precio">Precio</th>
              <th data-column-id="commands" data-formatter="commands" data-sortable="false">Operaciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        {{Form::open(['id'=>'frmEditarHabitacion', 'method'=>'put'])}}
        {{ csrf_field() }}
        <div class="modal-header" style="background-color:#385a94; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">MODFICAR HABITACIÓN</h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <div class="form-group">
                <input type="text" class="form-control numero input-sm" placeholder="NÚMERO" name="numero" id="numero_editar"
                  required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control numero input-sm" placeholder="PISO" name="piso" id="piso_editar"
                  required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control mayuscula input-sm" placeholder="TELEVISOR" name="televisor"
                  id="televisor_editar">
              </div>
              <div class="form-group">
                <input type="text" class="form-control moneda input-sm" placeholder="PRECIO" name="precio" id="precio_editar" required>
              </div>
              <div class="form-group">
                <select class="form-control input-sm" name="edificio_id" required id="edificio_id_editar">
                  <option value="">--SELECCIONAR EDIFICIO--</option>
                  @foreach(\App\Edificio::all() as $edificio)
                    <option value="{{$edificio->id}}">{{$edificio->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#385a94">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Modificar</button>
        </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
  <div class="modal fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        {{Form::open(['id'=>'frmEliminarHabitacion', 'method'=>'delete'])}}
        {{ csrf_field() }}
        <div class="modal-header" style="background-color:#bb0000; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">ELIMINAR HABITACION</h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <p>ESTA A PUNTO DE ELIMINAR LA HABITACIÓN <strong id="numero_eliminar"></strong> DEL EDIFICIO
                <strong id="edificio_eliminar"></strong>, CON ESTA ACCIÓN ELIMINARÁ TODOS
                LOS REGISTROS RELACIONADOS CON ESTA HABITACIÓN INCLUYENDO SUS HUESPEDES, RESERVACIONES, ETC.</p>
              <p>SI QUIERE CONTINUAR CON ESTA ACCIÓN HAGA CLIC EN EL BOTÓN ELIMINAR, DE LO CONTRARIO, EN EL BOTÓN
                CANCELAR.</p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#bb0000">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
          <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
        </div>
        {{Form::close()}}
      </div>
    </div>
  </div>
@stop

@section('scripts')
  {{Html::script('bootgrid/jquery.bootgrid.min.js')}}
  @include('habitaciones.inicio.scripts')
@stop
