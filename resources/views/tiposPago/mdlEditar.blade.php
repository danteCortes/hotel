<div class="fade modal" id="mdlEditarTipoPago">
  <div class="modal-dialog">
    <div class="modal-content">
      {{Form::open(['id'=>'frmEditarTipoPago', 'autocomplete'=>'off', 'class'=>'form-horizontal',
        '@submit.prevent'=>'modificarTipoPago(tipoPago.id)'])}}
        <div class="modal-header" style="background-color:#385a94; color:#fff;">
          {{Form::button('<span aria-hidden="true">&times;</span>', ['type'=>'button', 'class'=>'close',
            'data-dismiss'=>'modal'])}}
          <h4 class="modal-title">Editar Tipo de Pago</h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <div class="form-group">
                {{Form::label('nombre: ', null, ['class'=>'control-label col-sm-4'])}}
                <div class="col-sm-8">
                  {{Form::text('nombre', null, ['class'=>'form-control input-sm mayuscula', 'required'=>'',
                    'placeholder'=>'NOMBRE', 'v-model'=>'tipoPago.nombre'])}}
                  <span class="text-danger" v-for="error in errores.nombre" style="color: #880000">
                    @{{error}}</span>
                </div>
              </div>
              <div class="form-group">
                {{Form::label('descripción: ', null, ['class'=>'control-label col-sm-4'])}}
                <div class="col-sm-8">
                  {{Form::textarea('descripcion', null, ['class'=>'form-control input-sm mayuscula',
                    'placeholder'=>'DESCRIPCIÓN', 'v-model'=>'tipoPago.descripcion', 'rows'=>'3'])}}
                  <span class="text-danger" v-for="error in errores.descripcion" style="color: #880000">
                    @{{error}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#385a94">
          {{Form::button('<span class="fa fa-ban"> </span> Cancelar', ['type'=>'button', 
            'class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
          {{Form::button('<span class="fa fa-save"> </span> Modificar', ['type'=>'submit', 
            'class'=>'btn btn-primary'])}}
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>