<script type="text/javascript">
  Vue.component('habitacion', {
    props: ['numero'],
    template: "<strong>@{{numero}}</strong>"
  });

  Vue.component('edificio', {
    props: ['nombre'],
    template: "<strong>@{{nombre}}</strong>"
  });

  new Vue({
    el: '#wrap',
    created: function(){
      this.obtenerhabitaciones();
    },
    data: {
      habitaciones: [],
      habitacion: {
        id: '',
        numero: '',
        edificio_id: '',
        televisor: '',
        precio: '',
        piso: '',
        edificio: {
          id: '',
          nombre: '',
          ubicacion: ''
        },
        huespedes: []
      },
      nuevoHuesped: {
        dni: '',
        nombres: '',
        apellidos: '',
        telefono: '',
        salida: ''
      },
      huesped: {
        id: '',
        habitacion_id: '',
        persona_dni: '',
        inicio: '',
        salida: null,
        habitacion: {
          id: '',
          edificio_id: '',
          numero: '',
          piso: '',
          precio: '',
          televisor: '',
          edificio: {
            id: '',
            nombre: '',
            ubicacion: ''
          }
        },
        persona: {
          dni: '',
          nombres: '',
          apellidos: '',
          telefono: '',
          direccion: ''
        },
        pagos: []
      },
      errores: []
    },
    computed: {
      formatearFechaInicio: function(){
        return moment(this.huesped.inicio).format("DD/MM/YYYY HH:mm A");
      }
    },
    methods: {
      obtenerhabitaciones: function(){
        axios.get("../administrador/habitacion/todos").then(response=>{
          this.habitaciones = response.data;
        }).catch(errores => {
          console.log(errores.response.statusText);
          if (errores.response.statusText == 'Internal Server Error') {
            this.obtenerhabitaciones();
          }
        });
      },
      mostrarFrmRegistrar: function(habitacion){
        this.habitacion = habitacion;
        $("#registrar").modal("show");
      },
      registrarHuesped: function(){
        $("#fade").modal("show");
        $("#registrar").modal("hide");
        url = "administrador/huesped";
        axios.post(url, {
          dni: this.nuevoHuesped.dni,
          nombres: this.nuevoHuesped.nombres,
          apellidos: this.nuevoHuesped.apellidos,
          telefono: this.nuevoHuesped.telefono,
          salida: this.nuevoHuesped.salida,
          habitacion_id: this.habitacion.id
        }).then(response => {
          this.obtenerhabitaciones();
          this.habitacion = {
            id: '',
            numero: '',
            edificio_id: '',
            televisor: '',
            precio: '',
            piso: '',
            edificio: {
              id: '',
              nombre: '',
              ubicacion: ''
            },
            huespedes: []
          };
          this.nuevoHuesped = {
            dni: '',
            nombres: '',
            apellidos: '',
            telefono: '',
            salida: ''
          };
          this.errores = [];
          $("#fade").modal("hide");
          $("body").css('padding-right: 0px;');
          toastr.success("EL HUESPED FUE REGISTRADO CON ÉXITO.");
        }).catch(errors => {
          this.errores = errors.response.data;console.log(errors.response);
          $("#registrar").modal("show");
          $("#fade").modal("hide");
          $("body").css('padding-right: 0px;');
        });
      },
      obtenerHuesped: function(huespedes){
        respuesta = {
          inicio: '0000-01-01 00:00:00',
          salida: null,
          persona: {
            nombres: '',
            apellidos: ''
          }
        };
        $.each(huespedes, function (clave, huesped) { 
          if (huesped.inicio) {
            fecha_evaluada = new Date(respuesta.inicio).getTime();
            fecha = new Date(huesped.inicio).getTime();
            if (fecha_evaluada < fecha) {
              respuesta = huesped;
            }
          }
        });
        if (respuesta.salida) {
          salida = new Date(respuesta.salida).getTime() + (24*60*60*1000);
          hoy = new Date().getTime();
          if (salida > hoy) {
            return respuesta;
          }
        }else{
          return respuesta;
        }
      },
      mostrarFrmPagar: function(id){
        url = "administrador/huesped/" + id;
        axios.get(url).then(response => {
          this.habitacion = response.data.habitacion;
          fecha1 = moment('2018-04-02 09:24:00');
          fecha2 = moment('2018-04-06 02:44:53');
          console.log(fecha2.diff(fecha1, 'days'), ' dias de diferencia');
          $("#mdlPagar").modal("show");
        });
      },
      buscarPersona: function(dni){
        url = "administrador/persona/" + dni;
        axios.get(url).then(response => {
          this.nuevoHuesped.nombres = response.data.nombres;
          this.nuevoHuesped.apellidos = response.data.apellidos;
          this.nuevoHuesped.telefono = response.data.telefono;
        });
      },
      verPagos: function(huesped_id){
        url = "administrador/huesped/" + huesped_id;
        axios.get(url).then(response => {
          this.huesped = response.data;
          $("#mdlMostrarPagos").modal("show");
        });
      },
      formatearFecha: function(fecha){
        return moment(fecha).format("DD/MM/YYYY HH:mm A");
      }
    }
  })


  $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var grid = $("#tblHabitaciones-probar").bootgrid({
      labels: {
        all: "todos",
        infos: "",
        loading: "Cargando datos...",
        noResults: "Ningun resultado encontrado",
        refresh: "Actualizar",
        search: "Buscar"
      },
      ajax: true,
      post: function (){
        return {
          '_token': '{{ csrf_token() }}',
          id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
        };
      },
      url: "{{url('hotel/listar')}}",
      formatters: {
        "commands": function(column, row){
          reservar = "<button type='button' data-placement='bottom' title='Reservar' data-toggle='tooltip' class='btn btn-xs btn-warning command-reservar' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-flag'></span></button>";
          registrar = "<button type='button' data-placement='bottom' title='Registrar' data-toggle='tooltip' class='btn btn-xs btn-primary command-registrar' data-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-plus'></span></button>";
          ver  = "<button type='button' data-placement='bottom' title='Ver' data-toggle='tooltip' class='btn btn-xs btn-primary command-ver' data-huesped-id='"+row.huesped_id+"' style='margin:2px'>"+
          "<span class='fa fa-eye'></span></button>";
          modificar = "<button type='button' data-placement='bottom' title='Modificar' data-toggle='tooltip' class='btn btn-xs btn-primary command-modificar' data-huesped-id='"+row.huesped_id+"' style='margin:2px'>"+
          "<span class='fa fa-edit'></span></button>";
          cambiar = "<button type='button' data-placement='bottom' title='Cambiar' data-toggle='tooltip' class='btn btn-xs btn-info command-cambiar' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-refresh'></span></button>";
          limpiar = "<button type='button' data-placement='bottom' title='Limpiar' data-toggle='tooltip' class='btn btn-xs btn-success command-limpiar' data-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-leaf'></span></button>";
          pagar = "<button type='button' data-placement='bottom' title='Pagar' data-toggle='tooltip' class='btn btn-xs btn-success command-pagar' data-huesped-id='"+row.huesped_id+"' style='margin:2px'>"+
          "<span class='fa fa-money'></span></button>";
          pagos = "<button type='button' data-placement='bottom' title='Ver Pagos' data-toggle='tooltip' class='btn btn-xs btn-success command-verpagos' data-huesped-id='"+row.huesped_id+"' style='margin:2px'>"+
          "<span class='fa fa-money'></span></button>";
          observaciones = "<button type='button' data-placement='bottom' title='Observaciones' data-toggle='tooltip' class='btn btn-xs btn-warning command-delete' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-warning'></span></button>";
          if (row.huesped) {
            if (row.limpieza) {
              return ver + modificar + cambiar + pagar + pagos + observaciones;
            }else{
              return ver + modificar + cambiar + limpiar + pagar + pagos + observaciones;
            }
          }else{
            return registrar + reservar;
          }
        },
        "alertas": function(column, row){
          if (row.huesped) {
            // la habitación tiene un huesped verificamos si son mas de las 6:00 am y si no se le a hecho una limpieza
            column.cssClass = "alerta";
          }else{
            column.cssClass = "";
          }
          return row.numero;
        }
      }
    }).on("loaded.rs.jquery.bootgrid", function(){
      // setInterval(function(){
      //   if ($(".alerta").hasClass('rojo')) {
      //     $(".alerta").removeClass('rojo');
      //   }else {
      //     $(".alerta").addClass('rojo');
      //   }
      // }, 500);
      /* Se ejecuta despues de cargar y procesar los datos */
      grid.find(".command-registrar").on("click", function(e){
        $(".dni").val("");
        $(".nombres").val("");
        $(".apellidos").val("");
        $(".telefono").val("");
        $(".precio").val("");
        $(".salida").val("");
        $.get(
          "{{url('hotel/habitacion')}}/"+$(this).data("id"), 
          function(habitacion, textStatus, xhr) {
            $(".hab_numero").html(habitacion['numero']);
            $(".edif_nombre").html(habitacion['edificio']['nombre']);
            $("#frmRegistrarHuesped > div.modal-footer > input[type='hidden'][name='habitacion_id']").val(habitacion['id']);
            $(".precio").val(parseFloat(habitacion['precio']).toFixed(2));
            $("#registrar").modal('show');
          }
        );
      }).end().find(".command-ver").on('click', function(e) {
        $.get(
          "{{url('hotel/huesped')}}/"+$(this).data("huesped-id"),
          function(huesped, textStatus, xhr) {
            $(".huesped").html(huesped['persona']['nombres']+' '+huesped['persona']['apellidos']);
            $(".television").html(huesped['habitacion']['televisor']);
            $(".precio").html(parseFloat(huesped['habitacion']['precio']).toFixed(2));
            $(".inicio").html(moment(huesped['inicio']).format('DD/MM/YYYY HH:mm A'));
            if (huesped['salida']) {
              $(".salida").html(moment(huesped['salida']).format('DD/MM/YYYY'));
            }else {
              $(".salida").empty();
            }
            $(".hab_numero").html(huesped['habitacion']['numero']);
            $(".edif_nombre").html(huesped['habitacion']['edificio']['nombre']);
            $("#ver").modal('show');
          }
        );
      }).end().find(".command-modificar").on('click', function(e) {
        $.get(
          "{{url('hotel/huesped')}}/"+$(this).data("huesped-id"), 
          function(huesped, textStatus, xhr) {
            $(".dni").val(huesped['persona']['dni']);
            $(".nombres").val(huesped['persona']['nombres']);
            $(".apellidos").val(huesped['persona']['apellidos']);
            $(".telefono").val(huesped['persona']['telefono']);
            if (huesped['salida']) {
              $(".salida").val(moment(huesped['salida']).format('DD/MM/YYYY'));
            }else{
              $(".salida").val("");
            }
            $(".hab_numero").html(huesped['habitacion']['numero']);
            $(".edif_nombre").html(huesped['habitacion']['edificio']['nombre']);
            $("#frmEditarHuesped > div.modal-footer > input[type='hidden'][name='habitacion_id']").val(huesped['habitacion']['id']);
            $("#frmEditarHuesped").prop('action', "{{url('hotel/huesped')}}/" + huesped['id']);
            $("#mdlEditarHuesped").modal('show');
          }
        );
      }).end().find(".command-verpagos").on('click', function(e) {
        $.get("{{url('hotel/huesped')}}/"+$(this).data("huesped-id"), 
          function(huesped, textStatus, xhr) {
            $(".hab_numero").html(huesped['habitacion']['numero']);
            $(".edif_nombre").html(huesped['habitacion']['edificio']['nombre']);
            filas = `<tr>
              <th class="text-center">FECHA Y HORA</th>
              <th class="text-center">CONCEPTO</th>
              <th class="text-center">MONTO</th>
            </tr>`;
            $.each(huesped['pagos'], function (clave, pago) { 
              filas += `<tr>
                <td class="text-left">${moment(pago['fecha']).format('DD/MM/YYYY HH:mm A')}</td>
                <td class="text-left">${pago['concepto']}</td>
                <td class="text-right">${parseFloat(pago['monto']).toFixed(2)}</td>
              </tr>`;
            });
            $("#tblMostrarPagos").html(filas);
            $("#mdlMostrarPagos").modal('show');
          }
        );
      }).end().find(".command-pagar").on('click', function(e) {
        $.get("{{url('hotel/huesped')}}/"+$(this).data("huesped-id"), 
          function(huesped, textStatus, xhr) {
            $(".hab_numero").html(huesped['habitacion']['numero']);
            $(".edif_nombre").html(huesped['habitacion']['edificio']['nombre']);
            $("#frmPagar > div.modal-footer > input[type='hidden'][name='huesped_id']").val(huesped['id']);
            $("#mdlPagar").modal('show');
          }
        );
      }).end().find(".command-limpiar").on('click', function(e) {
        $.get("{{url('hotel/habitacion')}}/"+$(this).data("id"), 
          function(habitacion, textStatus, xhr) {
            $(".hab_numero").html(habitacion['numero']);
            $(".edif_nombre").html(habitacion['edificio']['nombre']);
            $("#frmLimpiar > input[type='hidden'][name='habitacion_id']").val(habitacion['id']);
            $("#mdlLimpiar").modal('show');
          }
        );
      });
    });

    $('.moneda').mask("###0.00", {reverse: true});
    $('.numero').mask("###", {reverse: true});
    $('.dni').mask("99999999", {reverse: true});

  });
</script>
