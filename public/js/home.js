            $('#hour_start').timepicker({
                uiLibrary: 'bootstrap4'
            });
            $('#hour_end').timepicker({
                uiLibrary: 'bootstrap4'
            });

            $("#number-machine").autocomplete({
              source: [ "4006", "385", "3192"]
            });
            $(document).ready(function(){
                $('#tbl-stop').DataTable({
                    language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                    },
                    lengthMenu: [20, 40, 80, 160, 400, 500, 1000],
                    responsive: true,
                    ajax: {
                            url: '/stopMachine',
                            dataSrc: '',
                    },
                    columns: [
                        { data: 'id_machine'},
                        { data: 'problem'},
                        { data: 'hour_start'},
                        { data: 'hour_end'},
                        { data: 'id_employee'},
                        { data: null,
                            render: function (data, type, row) {
                                return "<div class='d-flex justify-content-around'>" +
                                        "<button type='submit' id='"+data.id+"' "+
                                        "class='btn btn-danger btn-delete-problem' "+
                                        "data-token='{{ csrf_token() }}' "+
                                        "data-id-problem='"+data.id+"' "+
                                        "data-name='"+data.id_machine+" - "+data.id_machine+"'>Borrar</button>"+
                                    "</div>";
                            }
                        }
                    ]
                }); //dataTable
            });

            $('.view-stop').on('click', function(){
                $('#tbl-stop').DataTable().ajax.reload();
            });
    $("#tbl-stop").delegate('.btn-delete-problem', 'click', function(){
        var id = $(this).attr('data-id-problem');
        var itemName = $(this).attr('data-name');

        Swal.fire({
            title: '¿Estas seguro?',
            text: "Eliminar " + itemName,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                  title: 'Eliminando...',
                  timerProgressBar: true,
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  didOpen: () => {
                    Swal.showLoading()
                    
                    $.ajax({
                        url: "paros/"+id,
                        type: 'DELETE', 
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { 
                                "id": id, 
                                "_method": 'DELETE', 
                        },
                        success: function(res){
                            if (res.status == 1) {
                                Swal.close();

                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Paro eliminado exitosamente',
                                    showConfirmButton: false,
                                    timer: 900
                                });

                                $('#tbl-stop').DataTable().ajax.reload();
                            }else{
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: 'Error',
                                    text: 'Ocurrio un problema'
                                });
                            }
                        }
                    }); 
                    
                  }
                }).then((result) => {
                  if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                  }
                });
            }
        });
    });

$('#btn-save-stop').on('click', function(){

    $.ajax({
        url: "paros",
        method:"POST",
        data: $("#create-stop").serialize(),
        success: function(res){
            console.log(res);
            if (res.status) {

                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Registro guardado',
                  showConfirmButton: false,
                  timer: 900
                });

                $('#mdl-add-stop').modal('hide');
                $('#tbl-stop').DataTable().ajax.reload();
                $("#create-stop").trigger("reset");
            }
        }
    }); 
});