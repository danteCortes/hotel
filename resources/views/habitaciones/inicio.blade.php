@extends('plantillas.administrador')

@section('estilos')
{{Html::style('bootgrid/jquery.bootgrid.min.css')}}
{{Html::style('assets/css/toastr.css')}}
@stop

@section('titulo')
  Habitaciones
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
    <span class="glyphicon glyphicon-plus"></span> Nuevo
  </button>
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
              <th data-column-id="televisor">Televisor</th>
              <th data-column-id="precio">Precio</th>
              <th data-column-id="commands" data-formatter="commands" data-sortable="false">Operaciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  @include('habitaciones.mdlNuevo')
  @include('habitaciones.mdlEditar')
  @include('habitaciones.mdlEliminar')
  @stop

@section('scripts')
  {{Html::script('bootgrid/jquery.bootgrid.min.js')}}
  {{Html::script('assets/js/vue.js')}}
  {{Html::script('assets/js/axios.js')}}
  {{Html::script('assets/js/toastr.js')}}
  @include('habitaciones.scripts')
  <script>
    new Vue({
      el: "#wrap",
      data: {
        nuevoEdificio: {
          numero: '',
          piso: null,
          televisor: '',
          precio: '',
          edificio_id: ''
        },
        errores: [],
        edificios: []
      },
      created: function(){
        this.llenarEdificios();
      },
      methods:{
        llenarEdificios: function(){
          axios.get("../administrador/edificio/todos").then(response => {
            this.edificios = response.data;
          });
        },
        guardarHabitacion: function(){
          $("#fade").modal("show");
          $("#nuevo").modal("hide");
          axios.post("../administrador/habitacion", this.nuevoEdificio).then(response => {
            $("#tblHabitaciones").bootgrid("reload");
            this.nuevoEdificio = {
              numero: '',
              piso: null,
              televisor: '',
              precio: '',
              edificio_id: ''
            };
            this.errores = [];
            toastr.success("LA HABITACIÓN FUE CREADA CON ÉXITO");
            $("#fade").modal("hide");
          }).catch(errores => {
            this.errores = errores.response.data;
            $("#nuevo").modal("show");
            $("#fade").modal("hide");
          });
        }
      }
    })
  </script>
@stop
