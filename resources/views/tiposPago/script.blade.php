<script>

  Vue.component('tipo-pago', {
    props: ['tipo-pago'],
    template: "<strong>@{{tipoPago}}</strong>"
  });

  new Vue({
    el: '#wrap',
    created: function(){
      this.obtenerTiposPago();
    },
    data: {
      tiposPago: [],
      tipoPago: {
        id: '',
        nombre: '',
        descripcion: ''
      },
      nuevoTipoPago: {
        nombre: '',
        descripcion: ''
      },
      errores: []
    },
    methods: {
      obtenerTiposPago: function(){
        url = "../administrador/tipo-pago/todos";
        axios.get(url).then(response => {
          this.tiposPago = response.data;
        }).catch(errores => {
          this.obtenerTiposPago();
        });
      },
      guardarTipoPago: function(){
        $("#fade").modal("show");
        $("#mdlNuevoTipoPago").modal("hide");
        url = "../administrador/tipo-pago";
        axios.post(url, this.nuevoTipoPago).then(response => {
          this.obtenerTiposPago();
          this.nuevoTipoPago = {
            nombre: '',
            descripcion: ''
          };
          this.errores = [];
          $("#fade").modal("hide");
          toastr.success("EL TIPO DE PAGO FUE REGISTRADO CON ÉXITO.");
        }).catch(errores => {
          this.errores = errores.response.data;
          $("#fade").modal("hide");
          $("#mdlNuevoTipoPago").modal("show");
        });
      },
      editarTipoPago: function(tipoPago){
        this.tipoPago = tipoPago;
        $("#mdlEditarTipoPago").modal("show");
      },
      modificarTipoPago: function(id){
        $("#fade").modal("show");
        $("#mdlEditarTipoPago").modal("hide");
        url = "../administrador/tipo-pago/" + id;
        axios.put(url, this.tipoPago).then(response => {
          this.obtenerTiposPago();
          this.tipoPago = {
            id: '',
            nombre: '',
            descripcion: ''
          };
          this.errores = [];
          $("#fade").modal("hide");
          toastr.success("EL TIPO DE PAGO FUE MODIFICADO CON ÉXITO.");
        }).catch(errores => {
          this.errores = errores.response.data;
          $("#fade").modal("hide");
          $("#mdlEditarTipoPago").modal("show");
        });
      },
      advertenciaEliminarTipoPago: function(tipoPago){
        this.tipoPago = tipoPago;
        $("#mdlEliminarTipoPago").modal("show");
      },
      eliminarTipoPago: function(id){
        $("#fade").modal("show");
        $("#mdlEliminarTipoPago").modal("hide");
        url = "../administrador/tipo-pago/" + id;
        axios.delete(url).then(response => {
          this.obtenerTiposPago();
          this.tipoPago = {
            id: '',
            nombre: '',
            descripcion: ''
          };
          $("#fade").modal("hide");
          toastr.info("EL TIPO DE PAGO FUE ELIMINADO CON ÉXITO.");
        });
      }
    }
  })



</script>