var employees = [];
var machines = [];
var hour_stops = [];
var stops = ['Baja resistencia', 'Centrado', 'Altura', 'Punto A alto', 'Variacion de medida', 'Ajuste de tecnico', 'Cambio de electro', 'Punto A bajo','T gap'];


/*bugs - 
    reconsulta ajax
            la hora de fin en paro de maquina no debe ser mayor a la hora de inicio
            Al agregar un nuevo empleado no borrar el registro del paro
        En el campo responsable agregar la opcion de seleccionar solo el puesto
            Error al no encontrar una maquina
            Mensaje de registro duplicado
            ver la descipcion de la quina seleccionada al registrar un paro*/


$.get( "employee", function( data ) {
    for (index in data) {
        employees.push({'label': data[index].id, 'name': data[index].name, 'position': data[index].position})        
    }
});

$.get( "machine", function( data ) {
    for (index in data) {
        var machine = data[index].id;
        machine = machine.split('-');
        machines.push({'label': machine[1], 'name': data[index].name, 'step': data[index].number_step})        
    }
});

$.get( "stopMachine", function( data ) {
    hour_stops = data;
});


$(document).ready(function(){
    $('table.display').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        lengthMenu: [20, 40, 80, 160, 400, 500, 1000],
        responsive: true,
        order: [[ 8, "desc" ]],
        ajax: {
                url: '/stopMachine',
                dataSrc: '',
        },
        createdRow: function( row, data, dataIndex){
                if( data.hour_end == '00:00'){
                    $(row).addClass('redClass');
                }
        },
        columnDefs: [
            {
                "targets": [8],
                "visible": false,
                "searchable": false
            }
        ],
        columns: [
            { data: 'id_machine'},
            { data: 'description'},
            { data: 'problem'},
            { data: 'hour_start'},
            { data: 'hour_end'},
            { data: null, 
                render: function(data, type, row){
                    
                     
                    if (data.hour_end == '00:00'){
                        return 0;
                    }else{
                        var start_time = moment(data.hour_start, "HH:mm");
                        var end_time = moment(data.hour_end, "HH:mm");

                        var hour = end_time.diff(start_time, 'hours');
                        var minutes = end_time.diff(start_time, 'minutes');

                        hour < 10 ? hour = "0" + hour : hour;
                        minutes < 10 ? minutes = "0" + minutes : minutes;

                        return hour + ":" + minutes;
                    }

                }
            },
            { data: 'name'},
            { data: null,
                render: function (data, type, row) {
                    var machine = data.id_machine.split('-');
                    var problem = data.problem;
                    var description = data.description;
                    var hour_start = data.hour_start;
                    var hour_end = data.hour_end;
                    var id_employee = data.employee;
                    var name_employee = data.name;

                    return "<div class='d-flex justify-content-around'>" +
                                "<button class='btn btn-info btn-edit-stop' " + 
                                    "data-toggle='modal' "+
                                    "data-target='#mdl-add-stop' " + 
                                    "onclick='editStop("+data.id+",`"+machine[1]+"`,`"+description+"`,`"+problem+"`,`"+hour_start+"`,`"+hour_end+"`,`"+id_employee+"`,`"+name_employee+"`)'> Editar </button>" + 
                                "<button class='btn btn-danger btn-delete-problem' "+
                                    "data-id-problem='"+data.id+"' "+
                                    "data-name='"+data.id_machine+" - "+data.problem+"'>Eliminar</button>"+
                           "</div>";
                }
            },
            { data: 'updated'},

        ]
    }); //dataTable
});//

$("#id_machine").autocomplete({
    source: machines,
    select: function(event, ui) {
        $('#description_machine').text(ui.item.name);
    }
});

$("#problem").autocomplete({
    source: stops,
    select: function(event, ui) {
        $('#problem').text(ui.item.id);
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

$('#id_machine').on('change', function(){
    var id_machine = $('#id_machine').val();

    for (index in machines) {
        if (machines[index].label != id_machine) {
            $('.msg-error-machine').show();
        }else{
            $('.msg-error-machine').hide();
            break;
        }
    }
});

$('#hour_start').on('change', function(){
    var id_machine = $('#id_machine').val();
    var hour_start = $('#hour_start').val();
    var data_hour =  $('#hour_start').attr('data-hour_start');

    for (index in hour_stops) {
        var machine = hour_stops[index].id_machine.split('-');
        var hour = hour_stops[index].hour_start;

        if (((hour_start == hour) && (id_machine == machine[1])) && (data_hour != hour_start)) {
            $('.msg-error-repeated').show();
        }else{
            $('.msg-error-repeated').hide();
        }
    }
});


$('#hour_end').on('change', function(){
    var hour_start = $('#hour_start').val();
    var hour_end =  $('#hour_end').val();

    var start_time = moment(hour_start, "HH:mm");
    var end_time = moment(hour_end, "HH:mm");

    //Comprueba que los hora de paro sea menor que los hora de correction
    if (end_time.diff(start_time, 'hours') < 0) {
        $('.msg-error-hour').show();
    }else{
        $('.msg-error-hour').hide();

        //Comprueba que los minutos de paro sea menor que los minutos de correction
        if (end_time.diff(start_time, 'minutes') < 0) {
            $('.msg-error-hour').show();
        }else{
            $('.msg-error-hour').hide();
        }
    }

});

$('#hour_end').timepicker({
    uiLibrary: 'bootstrap4'
});


$('.view-stop').on('click', function(){
    $('table.display').DataTable().ajax.reload();
});

$(".table.display").delegate('.btn-delete-problem', 'click', function(){
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

                                swalMessage('success', 'Registro eliminado exitosamente');

                                $('.table.display').DataTable().ajax.reload();
                            }else{
                                swalMessage('warning', 'Error', 'Ocurrio un problema');
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
    $('.msg-error-repeated').hide();
    $('#hour_start').attr('data-hour_start', '');
    
    $("#create-stop").trigger("reset");

    $('#description_machine').text('');
    $('#name-employee').text('');

    $('#btn-save-stop').attr('data-submit', 'create');
}

function editStop(id, machine, description_machine, problem, hour_start, hour_end, id_employee, name_employee){
    $('#modal-view').modal('hide');
    $('.msg-error-repeated').hide();

    $('#hour_start').attr('data-hour_start', hour_start);

    $('#description_machine').text(description_machine);

    $('#title-modal-add-stop').text('Editar registro');

    $('#id_machine').val(machine);
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
                        if (res.status) {
  
                            swalMessage('success', 'Registro guardado');

                            $('#mdl-add-stop').modal('hide');
                            $('table.display').DataTable().ajax.reload();
                            $("#create-stop").trigger("reset");
                        }
                    }, 
                    error: function(){
                        swalMessage('warning', 'Error', 'Registro no guardado, verifica que los datos estén correctos');

                        $('#mdl-add-stop').modal('hide');
                        $("#create-stop").trigger("reset");
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
        if(result.isConfirmed) {
            $('#name-empl').val()
            $('#number-employee').val($('#id_employee').val());
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

                    $('#name-employee').text($('#name-empl').val());
                    $('#mdl-add-employee').modal('hide');
                    $("#create-employee").trigger("reset");
                }
            }
        });
});

//Modal encima de otra modal
$(document).on('show.bs.modal', '.modal', function (event) {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});