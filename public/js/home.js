var employees = [];
var machines = [];

$.get( "employee", function( data ) {
    for (index in data) {
        employees.push({'label': data[index].id, 'name': data[index].name, 'position': data[index].position})        
    };
});

$.get( "machine", function( data ) {
    for (index in data) {
        var machine = data[index].id;
        machine = machine.split('-');
        machines.push({'label': machine[1], 'name': data[index].name, 'step': data[index].number_step})        
    };
});

$(document).ready(function(){
    $('table.display').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        lengthMenu: [20, 40, 80, 160, 400, 500, 1000],
        responsive: true,
        ajax: {
                url: '/stopMachine',
                dataSrc: '',
        },
        createdRow: function( row, data, dataIndex){
                if( data.hour_end ==  `00:00`){
                    $(row).addClass('redClass');
                }
        },
        columns: [
            { data: 'id_machine'},
            { data: 'description'},
            { data: 'problem'},
            { data: 'hour_start'},
            { data: 'hour_end'},
            { data: null, 
                render: function(data, type, row){
                    // Calcula los minutos de cada hora
                    var minutos_inicio = data.hour_start.split(':')
                        .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
                     
                    if (data.hour_end == '00:00'){
                        return 0;
                    }else{
                        var minutos_final = data.hour_end.split(':')
                          .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
                          
                        return (((minutos_final - minutos_inicio) /60) % 60);
                    }

                }
            },
            { data: 'name'},
            { data: null,
                render: function (data, type, row) {
                    var maquina = data.id_machine.split('-');
                    var problem = data.problem;
                    var hour_start = data.hour_start;
                    var hour_end = data.hour_end;
                    var id_employee = data.employee;
                    var name_employee = data.name;

                    return "<div class='d-flex justify-content-around'>" +
                                "<button class='btn btn-info btn-edit-stop' " + 
                                    "data-toggle='modal' "+
                                    "data-target='#mdl-add-stop' " + 
                                    "onclick='editStop("+data.id+",`"+maquina[1]+"`,`"+problem+"`,`"+hour_start+"`,`"+hour_end+"`,`"+id_employee+"`,`"+name_employee+"`)'> Editar </button>" + 
                                "<button class='btn btn-danger btn-delete-problem' "+
                                    "data-id-problem='"+data.id+"' "+
                                    "data-name='"+data.id_machine+" - "+data.problem+"'>Eliminar</button>"+
                           "</div>";
                }
            }
        ]
    }); //dataTable
});//

$("#number-machine").autocomplete({
    source: machines,
    select: function(event, ui) {
        $('#number-machine').text(ui.item.id);
    }
});

$("#id_employee").autocomplete({
    source: employees,
    select: function(event, ui) {
        $('#name-employee').text(ui.item.name);
    }
});

$('#hour_start').timepicker({
    uiLibrary: 'bootstrap4'
});


$('#hour_end').timepicker({
    uiLibrary: 'bootstrap4'
});


$('.view-stop').on('click', function(){
    $('table.display').DataTable().ajax.reload();
});

$("#tbl-stop").delegate('.btn-delete-problem', 'click', function(){
        var id = $(this).attr('data-id-problem');
        var item_name = $(this).attr('data-name');
        
        Swal.fire({
            title: '¿Estas seguro?',
            text: "Eliminar " + item_name,
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
                                    title: 'Registro eliminado exitosamente',
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

function saveStop(){
    $('#title-modal-add-stop').text('Agregar paro de maquina');
    
    $("#create-stop").trigger("reset");
    $('#name-employee').text('');

    $('#btn-save-stop').attr('data-submit', 'create');
}

function editStop(id, machine, problem, hour_start, hour_end, id_employee, name_employee){
    $('#modal-view').modal('hide');

    $('#title-modal-add-stop').text('Editar registro');

    $('#number-machine').val(machine);
    $('#problem').val(problem);
    $('#hour_start').val(hour_start);
    $('#hour_end').val(hour_end);
    $('#id_employee').val(id_employee);
    $('#name-employee').text(name_employee);

    $('#btn-save-stop').attr('data-id', id);
    $('#btn-save-stop').attr('data-submit', 'update');
}

$('#btn-save-stop').on('click', function(){
        var action_submit = $('#btn-save-stop').attr('data-submit');

        if (action_submit  == 'update') {
            if (_.some(employees, ['label', parseInt($('#id_employee').val())])) {
                
                var id = $('#btn-save-stop').attr('data-id');

                $.ajax({
                    url: "/paros/"+id,
                    dataType: "JSON",
                    method:"PUT",
                    data: $("#create-stop").serialize() + '&_method=' + "PUT",
                    success: function(res){
                        console.log(res)
                        if (res.status == 200) {

                            swalMessage('success', 'Registro actualizado')

                            $('#mdl-add-stop').modal('hide');
                            $('table.display').DataTable().ajax.reload();
                            $("#create-stop").trigger("reset");
                        }
                    }, 
                    error: function(){
                            swalMessage('warning', 'Error', 'Los datos no fueron actualizados, intente mas tarde');

                            $('#mdl-add-stop').modal('hide');
                            $("#create-stop").trigger("reset");
                    }
                });
            }else{
                employeeNotRegistered();
            }
        }else{
            if (_.some(employees, ['label', parseInt($('#id_employee').val())])) {
                $.ajax({
                    url: "paros",
                    dataType: "JSON",
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
                            $('table.display').DataTable().ajax.reload();
                            $("#create-stop").trigger("reset");
                        }
                    }
                });
            }else{
                employeeNotRegistered();
            }
        }
});


function employeeNotRegistered(){
    Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'Empleado no encontrado',
        text: 'Debes registrar los datos del emplado',
    }).then((result) => {
        if (result.isConfirmed) {
                $('#name-empl').val()
                $('#number-employee').val($('#id_employee').val());
                $('#mdl-add-stop').modal('hide');
                $('#mdl-add-employee').modal('show');
            }
    });
}

function swalMessage(typeMessage, title, text = ''){
    if (typeMessage == 'success') {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: title,
            showConfirmButton: false,
            timer: 900
        });
    }else if (typeMessage == 'warning') {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: title,
            text: text
        });
    }
}

/*
$('#btn-save-stop').on('click', function(){
    var action = $('#btn-save-stop').attr('data-submit');
    var id = $('#btn-save-stop').attr('id');
     
    if (action == 'update') {
        if (_.some(employees, ['label', parseInt($('#id_employee').val())])) {
            $.ajax({
                url: "paros/"+id,
                dataType: "JSON",
                method:"PUT",
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
                        $('#table.display').DataTable().ajax.reload();
                        $("#create-stop").trigger("reset");
                    }
                }
            });
        }else{
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Empleado no encontrado',
                text: 'Debes registrar los datos del emplado',
            }).then((result) => {
                if (result.isConfirmed) {
                        $('#name-empl').val()
                        $('#number-employee').val($('#id_employee').val());
                        $('#mdl-add-stop').modal('hide');
                        $('#mdl-add-employee').modal('show');
                    }
            });
        }
    }else{
        if (_.some(employees, ['label', parseInt($('#id_employee').val())])) {
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
                        $('#table.display').DataTable().ajax.reload();
                        $("#create-stop").trigger("reset");
                    }
                }
            });
        }else{
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Empleado no encontrado',
                text: 'Debes registrar los datos del emplado',
            }).then((result) => {
                if (result.isConfirmed) {
                        $('#name-empl').val()
                        $('#number-employee').val($('#id_employee').val());
                        $('#mdl-add-stop').modal('hide');
                        $('#mdl-add-employee').modal('show');
                    }
            });
        }
    }
});*/

$('#btn-save-employee').on('click', function(){
        $.ajax({
            url: "employee",
            method:"POST",
            data: $("#create-employee").serialize(),
            success: function(res){
                console.log(res);
                if (res.status) {

                    swalMessage('success', 'Registro guardado');

                    location.reload();
                    $('#mdl-add-employee').modal('hide');
                    $("#create-employee").trigger("reset");
                }
            }
        });
});

