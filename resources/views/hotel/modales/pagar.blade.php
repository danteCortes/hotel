<div class="modal fade" id="mdlPagar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      {{Form::open(['id'=>'frmPagar', 'class'=>'form-horizontal', 'autocomplete'=>'off', '@submit.prevent'=>'guardarPago'])}}
        {{ csrf_field() }}
        <div class="modal-header" style="background-color:#385a94; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">REGISTRAR PAGO EN HABITACIÓN 
            <habitacion :numero="habitacion.numero"></habitacion> EDIFICIO 
            <edificio :nombre="habitacion.edificio.nombre"></edificio> </h4>
        </div>
        <div class="modal-body" style="background-color:#e69c2d">
          <div class="panel" style="background-color:#bd7406">
            <div class="panel-body">
              <div class="form-group">
                {{Form::label(null, 'deuda', ['class'=>'control-label col-sm-3'])}}
              </div>
              <div class="form-group">
                {{Form::label('Pago: ', null, ['class'=>'control-label col-sm-3'])}}
                <div class="col-sm-9">
                  {{Form::text('monto', null, ['class'=>'form-control moneda input-sm', 'placeholder'=>'MONTO',
                    'required'=>'', ':value'=>'nuevoPago.monto', '@change'=>'cambiarMontoPago'])}}
                  <span class="text-danger" v-for="error in errores.monto" style="color: #880000">@{{error}}</span>
                </div>
              </div>
              <div class="form-group">
                {{Form::label('Tipo de Pago: ', null, ['class'=>'control-label col-sm-3'])}}
                <div class="col-sm-9">
                  <select name="tipo_pago_id" class="form-control input-sm" required v-model="nuevoPago.tipo_pago_id" 
                    @change="buscarMonto(nuevoPago.tipo_pago_id)">
                    <option value disabled>--SELECCIONAR TIPO DE PAGO--</option>
                    <option v-for="tipoPago in tiposPago" :value="tipoPago.id">@{{ tipoPago.nombre }}
                    </option>
                  </select>
                  <span class="text-danger" v-for="error in errores.tipo_pago_id" style="color: #880000">@{{error}}</span>
                </div>
              </div>
              <div class="form-group">
                {{Form::label('Descripción: ', null, ['class'=>'control-label col-sm-3'])}}
                <div class="col-sm-9">
                  {{Form::textarea('descripcion', null, ['class'=>'form-control mayuscula', 'placeholder'=>'DESCRIPCIÓN',
                    'v-model'=>'nuevoPago.descripcion', 'rows'=>'3'])}}
                  <span class="text-danger" v-for="error in errores.descripcion" style="color: #880000">@{{error}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color:#385a94">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar</button>
          <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>
            Registrar</button>
          {{Form::hidden('huesped_id', null)}}
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>
