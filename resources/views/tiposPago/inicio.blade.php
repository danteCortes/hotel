@extends('plantillas.administrador')

@section('estilos')
  {{Html::style('assets/css/toastr.css')}}
@endsection

@section('titulo')
  Tipos de Pago
  {{Form::button('<span class="fa fa-plus"> </span> Nuevo', ['type'=>'button', 'class'=>'btn btn-primary',
    'data-toggle'=>'modal', 'data-target'=>'#mdlNuevoTipoPago'])}}
@endsection

@section('contenido')
  <div class="row">
    <div class="col-xs-12">
      <table class="table table-responsive table-hover table-condensed table-striped table-bordered">
        <thead>
          <tr class="info">
            <th style="width: 250px">Tipo de Pago</th>
            <th>Descripción</th>
            <th style="width: 100px">Operaciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="tipoPago in tiposPago">
            <td>@{{ tipoPago.nombre }}</td>
            <td>@{{ tipoPago.descripcion }}</td>
            <td class="text-center">
              {{Form::button('<span class="fa fa-edit"></span>', ['type'=>'button', 'data-target'=>'tooltip', 
                'data-title'=>'Editar', 'class'=>'btn btn-warning btn-xs', 
                '@click.prevent'=>'editarTipoPago(tipoPago)'])}}
              {{Form::button('<span class="fa fa-trash"></span>', ['type'=>'button', 
                '@click.prevent'=>'advertenciaEliminarTipoPago(tipoPago)', 
                'class'=>'btn btn-danger btn-xs'])}}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  @include('tiposPago.mdlNuevo')
  @include('tiposPago.mdlEditar')
  @include('tiposPago.mdlEliminar')
@endsection

@section('scripts')
  {{Html::script('assets/js/vue.js')}}
  {{Html::script('assets/js/axios.js')}}
  {{Html::script('assets/js/toastr.js')}}
  @include('tiposPago.script')
@endsection