<script type="text/javascript">
  $(document).ready(function() {

    $("#frmNuevoEdificio").keypress(function(event) {
      if (event.which == 13) {
        return false;
      }
    });

    /*
     * Token necesario para hacer consultas por ajax.
     * Fecha 13/09/2017
     */
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    /**
     * Lista los productos llamanto por ajax al metodo lista del controlador ProveedorController.
     * Fecha 14/09/2017
    */
    var grid = $("#tblEdificios").bootgrid({
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
      url: "{{url('edificio/listar')}}",
      formatters: {
        "commands": function(column, row){
          return "<button type='button' class='btn btn-xs btn-warning command-edit' data-row-id='"+row.id+"' style='margin:2px'>"+
            "<span class='fa fa-edit'></span></button>"+
            "<button type='button' class='btn btn-xs btn-danger command-delete' data-row-id='"+row.id+"' style='margin:2px'>"+
              "<span class='fa fa-trash'></span></button>";
        }
      }
    }).on("loaded.rs.jquery.bootgrid", function(){
      /* Se ejecuta despues de cargar y procesar los datos */
      grid.find(".command-edit").on("click", function(e){
        $.post("{{url('edificio/buscar')}}", {id: $(this).data("row-id")}, function(data, textStatus, xhr) {
          $(".nombre").val(data['nombre']);
          $(".ubicacion").val(data['ubicacion']);
          $("#frmEditarEdificio").prop('action', "{{url('edificio')}}/" + data['id']);
          $("#editar").modal('show');
        });
      }).end().find(".command-delete").on('click', function(e) {
        $.post("{{url('edificio/buscar')}}", {id: $(this).data("row-id")}, function(data, textStatus, xhr) {
          $(".nombre").html(data['nombre']);
          $("#frmEliminarEdificio").prop('action', "{{url('edificio')}}/" + data['id']);
          $("#eliminar").modal('show');
        });
      });
    });

  });
</script>
