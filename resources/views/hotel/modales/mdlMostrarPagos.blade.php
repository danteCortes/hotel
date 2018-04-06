<div class="modal fade" id="mdlMostrarPagos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#385a94; color:#fff;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">PAGOS DE LA HABITACIÓN
          <habitacion :numero="huesped.habitacion.numero"></habitacion>
          EDIFICIO <edificio :nombre="huesped.habitacion.edificio.nombre"></edificio></h4>
      </div>
      <div class="modal-body" style="background-color:#e69c2d">
        <div class="panel" style="background-color:#bd7406">
          <div class="panel-body">
            <table class="table table-condensed table-bordered">
              <thead>
                <tr class="info">
                  <th>FECHA</th>
                  <th>MONTO</th>
                  <th>CONCEPTO</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="pago in huesped.pagos">
                  <td>@{{ formatearFecha(pago.fecha) }}</td>
                  <td>@{{ pago.monto }}</td>
                  <td>@{{ pago.tipo_pago.nombre }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="background-color:#385a94">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          <span class="glyphicon glyphicon-ban-circle"></span> Cerrar</button>
      </div>
    </div>
  </div>
</div>
