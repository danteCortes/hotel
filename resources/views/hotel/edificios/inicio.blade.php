@extends('plantillas.administrador')

@section('estilos')
{{Html::style('bootgrid/jquery.bootgrid.min.css')}}
<style media="screen">
  .operaciones{
    width: 207px;
  }
  .rojo{
    background-color: #ff0000;
  }
</style>
@stop

@section('titulo')
  Hotel - Edificio {{$edificio->nombre}}
@stop

@section('contenido')
  @include('plantillas.mensajes')
  <div class="text-center">
    @foreach(\App\Edificio::all() as $edif)
    <a class="quick-btn btn btn-metis-2" href="{{url('hotel/edificio/'.$edif->id)}}">
      <i class="fa fa-building-o fa-2x"></i>
      <span>{{$edif->nombre}}</span>
    </a>
    @endforeach
  </div><hr>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="table-responsive" id="imprimir-tabla">
        <table class="table table-hover table-condensed table-bordered" id="tblHabitaciones">
          <thead>
            <tr class="info">
              <th data-column-id="numero" data-formatter="alertas" data-width="77px;" data-order="asc">Numero</th>
              <th data-column-id="edificio">Edificio</th>
              <th data-column-id="huesped">Huesped</th>
              <th data-column-id="televisor">Televisor</th>
              <th data-column-id="precio">Precio</th>
              <th data-column-id="commands" data-formatter="commands" data-sortable="false" data-width="207px;">Operaciones</th>
            </tr>
          </thead>
        </table>
      </div>
      <button type="button" class="btn btn-primary imprimir">Imprimir</button>
    </div>
  </div>
  @include('hotel.modales.registrar')
  @include('hotel.modales.ver')
  @include('hotel.modales.editar')
  <div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#bb0000; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">HABITACIÓN OCUPADA</h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <p>LA HABITACIÓN <strong id="numero_error"></strong> DEL EDIFICIO
                <strong id="edificio_error"></strong>, SE ENCUENTRA OCUPADO, VUELVA A INTENTARLO O DESOCUPE LA HABITACIÓN,
                INGRESANDO EL PAGO POR LA HABITACIÓN Y HACIENDO EL CAMBIO RESPECTIVO.</p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#bb0000">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
        </div>
      </div>
    </div>
  </div>
@stop

@section('scripts')
  {{Html::script('bootgrid/jquery.bootgrid.min.js')}}
  {{Html::script('assets/js/jquery.printarea.js')}}
  @include('hotel.edificios.scripts')
@stop
