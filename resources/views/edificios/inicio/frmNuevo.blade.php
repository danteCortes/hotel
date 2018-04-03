<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nuevo">
  <span class="glyphicon glyphicon-plus"></span> Nuevo
</button>
<div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="administrador/edificio" id="frmNuevoEdificio" autocomplete="off" 
        v-on:submit.prevent="guardarEdificio()">
        {{ csrf_field() }}
        <div class="modal-header" style="background-color:#385a94; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">NUEVO EDIFICIO</h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <div class="form-group">
                <input type="text" class="form-control mayuscula input-sm" placeholder="NOMBRE" name="nombre" 
                  id="nombre"required v-model="nombre">
              </div>
              <div class="form-group">
                <input type="text" class="form-control mayuscula input-sm" placeholder="UBICACIÓN" 
                  name="ubicacion" id="ubicacion" v-model="ubicacion">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#385a94">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
