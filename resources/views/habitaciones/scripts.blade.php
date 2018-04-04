<script type="text/javascript">
  function llenarEdificiosEditar(id, callback){
    opciones = "<option disabled value>--SELECCIONAR EDIFICIO--</option>"
    $.get("../administrador/edificio/todos",
      function (edificios, textStatus, jqXHR) {
        $.each(edificios, function (clave, edificio) {
          if (id != edificio['id']) {
            opciones += `<option value="${edificio['id']}">${edificio['nombre']}</option>`;
          }
        });
        callback(opciones);
      }
    );
  }
  $(document).ready(function() {

    $("#frmNuevoEdificio").keypress(function(event) {
      if (event.which == 13) {
        return false;
      }
    });

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
      url: "{{url('administrador/habitacion/listar')}}",
      formatters: {
        "commands": function(column, row){
          return "<button type='button' class='btn btn-xs btn-warning command-edit' data-id='"+row.id+"' style='margin:2px'>"+
            "<span class='fa fa-edit'></span></button>"+
            "<button type='button' class='btn btn-xs btn-danger command-delete' data-id='"+row.id+"' style='margin:2px'>"+
              "<span class='fa fa-trash'></span></button>";
        }
      }
    }).on("loaded.rs.jquery.bootgrid", function(){
      /* Se ejecuta despues de cargar y procesar los datos */
      grid.find(".command-edit").on("click", function(e){
        $.get("{{url('administrador/habitacion')}}/"+$(this).data("id"), 
          function(habitacion, textStatus, xhr) {
            $("#habitacion_id").val(habitacion['id']);
            $("#numero_editar").val(habitacion['numero']);
            $("#piso_editar").val(habitacion['piso']);
            $("#televisor_editar").val(habitacion['televisor']);
            $("#precio_editar").val(habitacion['precio'].toFixed(2));
            $("#edificio_id_editar").html(`<option value="${habitacion['edificio_id']}">${habitacion['edificio']['nombre']}</option>`)
            llenarEdificiosEditar(habitacion['edificio_id'], function(opciones){
              $("#edificio_id_editar").append(opciones);
              $("#editar").modal('show');
            });
          }
        );
      }).end().find(".command-delete").on('click', function(e) {
        $.post("{{url('habitacion/buscar')}}", {id: $(this).data("row-id")}, function(data, textStatus, xhr) {
          $("#numero_eliminar").html(data[0]['numero']);
          $("#edificio_eliminar").html(data[2]['nombre']);
          $("#frmEliminarHabitacion").prop('action', "{{url('habitacion')}}/" + data[0]['id']);
          $("#eliminar").modal('show');
        });
      });
    });

    $("#frmEditarHabitacion").submit(function(event){
      event.preventDefault();
      $("#fade").modal("show");
      $("#editar").modal("hide");
      editarHabitacion = {
        numero: $("#numero_editar").val(),
        piso: $("#piso_editar").val(),
        televisor: $("#televisor_editar").val(),
        precio: $("#precio_editar").val(),
        edificio_id : $("#edificio_id_editar").val(),
        _method: 'put'
      };
      $.post("{{url('administrador/habitacion')}}/"+$("#habitacion_id").val(), editarHabitacion,
        function (data, textStatus, jqXHR) {
          $("#tblHabitaciones").bootgrid("reload");
          $("#fade").modal('hide');
          toastr.success("LA HABITACIÓN FUE MODIFICADA CON ÉXITO");
        }
      ).error(function(errores){
        $("#editar").modal("show");
      });
    });

    $('.moneda').mask("# ##0.00", {reverse: true});
    $('.numero').mask("###", {reverse: true});

  });
</script>
