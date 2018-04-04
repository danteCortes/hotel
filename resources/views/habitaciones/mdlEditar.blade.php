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
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#385a94">
          {{Form::hidden('habitacion_id', null, ['id'=>'habitacion_id'])}}
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> 
            Modificar</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>