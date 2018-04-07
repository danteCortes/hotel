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
  Hotel
@stop

@section('contenido')
  @include('plantillas.mensajes')
  <div class="text-center">
    @foreach(\App\Edificio::all() as $edificio)
    <a class="quick-btn btn btn-primary" href="{{url('hotel/edificio/'.$edificio->id)}}">
      <i class="fa fa-building-o fa-2x"></i>
      <span>{{$edificio->nombre}}</span>
    </a>
    @endforeach
  </div><hr>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="table-responsive" id="imprimir-tabla">
        <table class="table table-hover table-condensed table-bordered table-striped" id="tblHabitaciones">
          <thead>
            <tr class="info">
              <th data-column-id="numero" data-formatter="alertas" data-width="77px;" v-bind:style="{width: '80px'}">Numero</th>
              <th data-column-id="edificio" data-order="asc" v-bind:style="{width: '100px'}">Edificio</th>
              <th data-column-id="huesped">Huesped</th>
              <th data-column-id="televisor" v-bind:style="{width: '100px'}">Televisor</th>
              <th data-column-id="precio" v-bind:style="{width: '70px'}">Precio</th>
              <th data-column-id="commands" data-formatter="commands" data-sortable="false" data-width="207px;" v-bind:style="{width: '120px'}">Operaciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="habitacion in habitaciones">
              <td class="text-center">@{{habitacion.numero}}</td>
              <td class="text-left">@{{habitacion.edificio.nombre}}</td>
              <td class="text-left">@{{obtenerHuesped(habitacion.huespedes).persona.nombres + " " + obtenerHuesped(habitacion.huespedes).persona.apellidos}}</td>
              <td class="text-left">@{{habitacion.televisor}}</td>
              <td class="text-right">@{{habitacion.precio}}</td>
              <td class="text-center">
                <button v-if="!obtenerHuesped(habitacion.huespedes).id" class="btn btn-primary btn-xs" 
                  data-toggle="tooltip" title="Registrar" @click="mostrarFrmRegistrar(habitacion)">
                  <span class="fa fa-plus"></span>
                </button>
                <button v-if="obtenerHuesped(habitacion.huespedes).id" class="btn btn-success btn-xs" 
                  data-toggle="tooltip" title="Pagar" @click="mostrarFrmPagar(obtenerHuesped(habitacion.huespedes).id)">
                  <span class="fa fa-plus"></span>
                </button>
                {{Form::button('<span class="fa fa-eye"> </span>', ['type'=>'button', 'data-toggle'=>'tooltip', 
                  'title'=>'Ver Pagos', '@click.prevent'=>'verPagos(obtenerHuesped(habitacion.huespedes).id)',
                  'class'=>'btn btn-success btn-xs', 'v-if'=>'obtenerHuesped(habitacion.huespedes).id'])}}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <pre>
        @{{$data}}
      </pre>
      <button type="button" class="btn btn-primary imprimir">Imprimir</button>
    </div>
  </div>
  @include('hotel.modales.registrar')
  @include('hotel.modales.ver')
  @include('hotel.modales.editar')
  @include('hotel.modales.mdlMostrarPagos')
  @include('hotel.modales.pagar')
  @include('hotel.modales.mdlLimpiar')
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
  {{Html::script('assets/lib/moment/moment.min.js')}}
  {{Html::script('assets/js/vue.js')}}
  {{Html::script('assets/js/axios.js')}}
  @include('hotel.scripts')
@stop
