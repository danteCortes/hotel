<div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      {{Form::open(['id'=>'frmRegistrarHuesped', 'autocomplete'=>'off', '@submit.prevent'=>'registrarHuesped'])}}
        {{ csrf_field() }}
        <div class="modal-header" style="background-color:#385a94; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">REGISTRAR HUESPED HABITACIÓN 
            <habitacion :numero="habitacion.numero"></habitacion> EDIFICIO 
            <edificio :nombre="habitacion.edificio.nombre"></edificio>
          </h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <div class="form-group">
                <input type="text" v-model="nuevoHuesped.dni" class="form-control dni input-sm" placeholder="DNI*" name="dni"
                  required data-mask="99999999" @change="buscarPersona(nuevoHuesped.dni)">
                <span class="text-danger" v-for="error in errores.dni" style="color: #880000">@{{error}}</span>
              </div>
              <div class="form-group">
                <input type="text" class="form-control mayuscula input-sm" placeholder="NOMBRES*" name="nombres"
                  required v-model="nuevoHuesped.nombres">
                <span class="text-danger" v-for="error in errores.nombres" style="color: #880000">@{{error}}</span>
              </div>
              <div class="form-group">
                <input type="text" class="form-control mayuscula input-sm" placeholder="APELLIDOS*" name="apellidos"
                  required v-model="nuevoHuesped.apellidos">
                <span class="text-danger" v-for="error in errores.apellidos" style="color: #880000">@{{error}}</span>
              </div>
              <div class="form-group">
                <input type="text" class="form-control mayuscula input-sm" placeholder="TELÉFONO" name="telefono"
                  v-model="nuevoHuesped.telefono">
                <span class="text-danger" v-for="error in errores.telefono" style="color: #880000">@{{error}}</span>
              </div>
              <div class="form-group">
                <input type="text" v-bind:value="habitacion.precio" class="form-control input-sm precio" placeholder="PRECIO" name="precio"
                readonly>
              </div>
              <div class="form-group">
                <input type="text" class="form-control input-sm fecha" placeholder="SALIDA" name="salida"
                  v-model="nuevoHuesped.salida">
                <span class="text-danger" v-for="error in errores.salida" style="color: #880000">@{{error}}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#385a94">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> 
            Registrar</button>
          {{Form::hidden('habitacion_id', null, ['v-model'=>'habitacion.id'])}}
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>
