@extends('plantillas.administrador')

@section('estilos')
{{Html::style('bootgrid/jquery.bootgrid.min.css')}}
@stop

@section('titulo')
  Edificios
  @include('edificios.nuevo.frmNuevo')
@stop

@section('contenido')
  @include('plantillas.mensajes')
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
      <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered" id="tblEdificios">
          <thead>
            <tr class="info">
              <th data-column-id="id" data-order="desc">#</th>
              <th data-column-id="nombre">Nombre</th>
              <th data-column-id="ubicacion">Ubicación</th>
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
        {{Form::open(['id'=>'frmEditarEdificio', 'method'=>'put'])}}
        {{ csrf_field() }}
        <div class="modal-header" style="background-color:#385a94; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">MODFICAR EDIFICIO</h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <div class="form-group">
                <input type="text" class="form-control mayuscula input-sm nombre" placeholder="NOMBRE" name="nombre"
                  required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control mayuscula input-sm ubicacion" placeholder="UBICACIÓN" name="ubicacion">
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
        {{Form::open(['id'=>'frmEliminarEdificio', 'method'=>'delete'])}}
        {{ csrf_field() }}
        <div class="modal-header" style="background-color:#bb0000; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">ELIMINAR EDIFICIO</h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <p>ESTA A PUNTO DE ELIMINAR EL EDIFICIO <strong class="nombre"></strong>, CON ESTA ACCIÓN ELIMINARÁ TODOS
                LOS REGISTROS RELACIONADOS CON ESTE EDIFICIO INCLUYENDO SUS HABITACIONES, HUESPEDES, ETC.</p>
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
  @include('edificios.inicio.scripts')
@stop
