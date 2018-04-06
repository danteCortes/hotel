<div class="fade modal" id="mdlEliminarTipoPago">
  <div class="modal-dialog">
    <div class="modal-content">
      {{Form::open(['id'=>'frmEliminarTipoPago', 'autocomplete'=>'off', 'class'=>'form-horizontal',
        '@submit.prevent'=>'eliminarTipoPago(tipoPago.id)'])}}
        <div class="modal-header" style="background-color:#385a94; color:#fff;">
          {{Form::button('<span aria-hidden="true">&times;</span>', ['type'=>'button', 'class'=>'close',
            'data-dismiss'=>'modal'])}}
          <h4 class="modal-title">Eliminar Tipo de Pago</h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <p class="text justify">
                ESTA A PUNTO DE ELIMINAR EL TIPO DE PAGO <tipo-pago :tipo-pago="tipoPago.nombre"></tipo-pago>.
                SI ESTÁ SEGURO DE ESTA ACCIÓN PUEDE DAR CLIC EN EL BOTÓN ELIMINAR, DE LO CONTRARIO
                PUEDE CANCELAR ESTA ACCIÓN.
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#385a94">
          {{Form::button('<span class="fa fa-ban"> </span> Cancelar', ['type'=>'button', 
            'class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
          {{Form::button('<span class="fa fa-trash"> </span> Eliminar', ['type'=>'submit', 
            'class'=>'btn btn-primary'])}}
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>