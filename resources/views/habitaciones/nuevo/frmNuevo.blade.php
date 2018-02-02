<!--Boton para mostrar el modal con el formulario para ingresar los datos de una nueva habitacion-->
<!--Fecha 13/09/2017-->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
  <span class="glyphicon glyphicon-plus"></span> Nuevo
</button>
<!--Modal con el formulario para ingresar los datos de la nueva habitacion-->
<!--Fecha 13/09/2017-->
<div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      {{Form::open(['url'=>'habitacion', 'id'=>'frmNuevaHabitacion'])}}
      {{ csrf_field() }}
      <div class="modal-header" style="background-color:#385a94; color:#fff;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">NUEVA HABITACIÓN</h4>
      </div>
      <div class="modal-body" style="background-color:#e69c2d">
        <div class="panel" style="background-color:#bd7406">
          <div class="panel-body">
            <div class="form-group">
              <input type="text" class="form-control numero input-sm" placeholder="NÚMERO" name="numero" id="numero"
                required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control numero input-sm" placeholder="PISO" name="piso" id="piso"
                required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control mayuscula input-sm" placeholder="TELEVISOR" name="televisor" id="televisor">
            </div>
            <div class="form-group">
              <input type="text" class="form-control moneda input-sm" placeholder="PRECIO" name="precio" id="precio" required>
            </div>
            <div class="form-group">
              <select class="form-control input-sm" name="edificio_id" required>
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
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
      </div>
      {{Form::close()}}
    </div>
  </div>
</div>
