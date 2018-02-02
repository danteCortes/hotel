<script type="text/javascript">
  $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var grid = $("#tblHabitaciones").bootgrid({
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
          registrar = "<button type='button' data-placement='bottom' title='Registrar' data-toggle='tooltip' class='btn btn-xs btn-primary command-registrar' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-plus'></span></button>";
          ver  = "<button type='button' data-placement='bottom' title='Ver' data-toggle='tooltip' class='btn btn-xs btn-primary command-ver' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-eye'></span></button>";
          modificar = "<button type='button' data-placement='bottom' title='Modificar' data-toggle='tooltip' class='btn btn-xs btn-primary command-modificar' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-edit'></span></button>";
          cambiar = "<button type='button' data-placement='bottom' title='Cambiar' data-toggle='tooltip' class='btn btn-xs btn-info command-cambiar' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-refresh'></span></button>";
          limpiar = "<button type='button' data-placement='bottom' title='Limpiar' data-toggle='tooltip' class='btn btn-xs btn-success command-limpiar' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-leaf'></span></button>";
          pagar = "<button type='button' data-placement='bottom' title='Pagar' data-toggle='tooltip' class='btn btn-xs btn-success command-pagar' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-money'></span></button>";
          pagos = "<button type='button' data-placement='bottom' title='Ver Pagos' data-toggle='tooltip' class='btn btn-xs btn-success command-verpagos' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-money'></span></button>";
          observaciones = "<button type='button' data-placement='bottom' title='Observaciones' data-toggle='tooltip' class='btn btn-xs btn-warning command-delete' data-row-id='"+row.id+"' style='margin:2px'>"+
          "<span class='fa fa-warning'></span></button>";
          if (row.huesped) {
            return ver + modificar + cambiar + limpiar + pagar + pagos + observaciones;
          }else{
            return registrar + reservar;
          }
        },
        "alertas": function(column, row){
          if (row.huesped) {
            column.cssClass = "alerta";
          }else{
            column.cssClass = "";
          }
          return row.numero;
        }
      }
    }).on("loaded.rs.jquery.bootgrid", function(){
      setInterval(function(){
        if ($(".alerta").hasClass('rojo')) {
          $(".alerta").removeClass('rojo');
        }else {
          $(".alerta").addClass('rojo');
        }
      }, 500);
      /* Se ejecuta despues de cargar y procesar los datos */
      grid.find(".command-registrar").on("click", function(e){
        $.post("{{url('habitacion/buscar')}}", {id: $(this).data("row-id")}, function(data, textStatus, xhr) {
          if (data[3] == null) {
            $(".hab_numero").html(data[0]['numero']);
            $(".edif_nombre").html(data[2]['nombre']);
            $("#frmRegistrar").prop('action', "{{url('hotel/registrar')}}/" + data[0]['id']);
            $("#registrar").modal('show');
          }else{
            $("#numero_error").html(data[0]['numero']);
            $("#edificio_error").html(data[2]['nombre']);
            $("#error").modal('show');
          }
        });
      }).end().find(".command-ver").on('click', function(e) {
        $.post("{{url('hotel/buscar-huesped')}}", {id: $(this).data("row-id")}, function(data, textStatus, xhr) {
          $(".huesped").html(data[1]['nombres']+" "+data[1]['apellidos']);
          $(".television").html(data[0]['televisor']);
          $(".precio").html(data[0]['precio'].toFixed(2));
          $(".inicio").html(data[2]['inicio']);
          $(".salida").html(data[2]['salida']);
          $("#ver").modal('show');
        });
      }).end().find(".command-modificar").on('click', function(e) {
        $.post("{{url('hotel/buscar-huesped')}}", {id: $(this).data("row-id")}, function(data, textStatus, xhr) {
          $(".dni").val(data[1]['dni']);
          $(".nombres").val(data[1]['nombres']);
          $(".apellidos").val(data[1]['apellidos']);
          $(".telefono").val(data[1]['telefono']);
          $(".salida").html(data[2]['salida']);
          $("#frmEditar").prop('action', "{{url('hotel/modificar-huesped')}}/" + data[0]['id']);
          $("#editar").modal('show');
        });
      });
    });

    $(".imprimir").click(function (){
      $("#imprimir-tabla").printArea();
    });

    $('.moneda').mask("# ##0.00", {reverse: true});
    $('.numero').mask("###", {reverse: true});
    $('.dni').mask("99999999", {reverse: true});

  });
</script>
