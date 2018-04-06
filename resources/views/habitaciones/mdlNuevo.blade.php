<div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      {{Form::open(['url'=>'habitacion', 'id'=>'frmNuevaHabitacion', 'autocomplete'=>'off',
        'v-on:submit.prevent'=>'guardarHabitacion'])}}
        {{ csrf_field() }}
        <div class="modal-header" style="background-color:#385a94; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">NUEVA HABITACIÓN</h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <div class="form-group">
                <input type="text" class="form-control numero input-sm" placeholder="NÚMERO" name="numero" 
                  id="numero" required v-model="nuevoEdificio.numero">
                <span class="text-danger" v-for="error in errores.numero" v-bind:style="{color: '#880000'}">
                  @{{error}}</span>
              </div>
              <div class="form-group">
                <input type="text" class="form-control numero input-sm" placeholder="PISO" name="piso" id="piso"
                  required v-model="nuevoEdificio.piso">
                  <span class="text-danger" v-for="error in errores.piso" v-bind:style="{color: '#880000'}">
                    @{{error}}</span>
              </div>
              <div class="form-group">
                <input type="text" class="form-control mayuscula input-sm" placeholder="TELEVISOR" 
                  name="televisor" id="televisor" v-model="nuevoEdificio.televisor">
                <span class="text-danger" v-for="error in errores.televisor" v-bind:style="{color: '#880000'}">
                    @{{error}}</span>
              </div>
              <div class="form-group">
                <input type="text" class="form-control moneda input-sm" placeholder="PRECIO" name="precio" 
                  id="precio" required v-model="nuevoEdificio.precio">
                <span class="text-danger" v-for="error in errores.precio" v-bind:style="{color: '#880000'}">
                    @{{error}}</span>
              </div>
              <div class="form-group">
                <select class="form-control input-sm" name="edificio_id" required 
                  v-model="nuevoEdificio.edificio_id">
                  <option disabled value="">--SELECCIONAR EDIFICIO--</option>
                  <option v-for="edificio in edificios" v-bind:value="edificio.id">@{{edificio.nombre}}</option>
                </select>
                <span class="text-danger" v-for="error in errores.edificio_id" v-bind:style="{color: '#880000'}">
                  @{{error}}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#385a94">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> 
            Guardar</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>
