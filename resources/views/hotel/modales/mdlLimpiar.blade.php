<div class="modal fade" id="mdlLimpiar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#385a94; color:#fff;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">LIMPIAR LA HABITACIÓN <strong class="hab_numero"></strong>
          EDIFICIO <strong class="edif_nombre"></strong></h4>
      </div>
      <div class="modal-body" style="background-color:#e69c2d">
        <div class="panel" style="background-color:#bd7406">
          <div class="panel-body">
            <p class="text-justify">
              VA A LIMPIAR LA HABITACIÓN <strong class="hab_numero"></strong> EN EL EDIFICIO
              <strong class="edif_nombre"></strong>, SI ESTÁ SEGURO DE ESTA ACCIÓN DE CLICK EN 
              EL BOTÓN LIMPIAR, DE LO CONTRARIO PUEDE CANCELAR LA LIMPIEZA.
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="background-color:#385a94">
        {{Form::open(['route'=>'limpieza', 'id'=>'frmLimpiar'])}}
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
          {{Form::hidden('habitacion_id', null)}}
          {{Form::button('Limpiar', ['type'=>'submit', 'class'=>'btn btn-primary'])}}
        {{Form::close()}}
      </div>
    </div>
  </div>
</div>
