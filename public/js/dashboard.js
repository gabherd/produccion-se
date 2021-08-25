var responsableCorrection = [    ['Setup', 'Maquinas'] ];
var getTotalMachineStoped = [];
var colors = ['#03A9F4', '#FF9800', '#8BC34A', '#607D8B', '#7C4DFF', '#00BCD4', '#CDDC39', '#FF5722', '#E040FB', '#795548', '#D3C43F', '#009688', '#9E9E9E', '#FFC107', '#4CAF50', '#448AFF', '#536DFE', '#FF4081', '#FF5252'];
google.charts.load('current', {'packages':['corechart']});


getMachineNotRepaired();
getNameResponsable();
getTotalStopByMachine();

function getMachineNotRepaired(){
    $.get( "machineNotRepaired", function( data ) {
        $('#machineNotRepaired').text(data);
    });    
}

function getNameResponsable(){
    $.ajax({                                            
        url: 'getNameResponsable',                        
        dataType: 'json',
        async:false,                    
        success: function(data)          
        {   
           for(index in data){
             responsableCorrection.push([data[index].name_responsable, data[index].total]);
            }   
        },
        complete: function (data) {
              google.charts.setOnLoadCallback(chartNameResponsable);
        }
    });
}

function getTotalStopByMachine(){
    $.ajax({                                            
        url: 'qtyStopedByMachine',                        
        dataType: 'json',
        async:false,                    
        success: function(data)          
        {   
           for(index in data){
             getTotalMachineStoped.push({name: data[index].id_machine, y: data[index].total, process: data[index].name});
            }   
        },
        complete: function (data) {
            chartTotalHourStoped();
        }
    });
}

//obtiene cual setup tranaja mas
function chartNameResponsable() {

  var data = google.visualization.arrayToDataTable( responsableCorrection );

  var options = {
    title: 'Responsable de corrección'
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

  chart.draw(data, options);
}


//obtiene cuantas veces se han parado las maquinas
function chartTotalHourStoped(){
    Highcharts.chart('myChart', {
        chart: {
            type: 'column'
        },
        colors: colors,
        title: {
            text: 'Cantidad de paros'
        },
        exporting: {
            enabled: false
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            tickInterval: 1,
            title: {
                text: '# Paros'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: false,
                    format: '{point.y:.1f}'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
             pointFormat: '<b>Maquina: </b><span style="color:{point.color}">{point.name}</span> <br>'+
                         '<b>Proceso:</b> {point.process} <br>'+
                         '<b>Paros:</b>  {point.y} <br>'
        },
        series: [
            {
                name: "Cantidad de paros",
                colorByPoint: true,
                data: getTotalMachineStoped
            }
        ],
    });
}

//adapta el ancho del cocumento por el scroll lateral
$(document).ready(function(){
    if ($( window ).width() >= 900) {
        if ($( document ).height() > $( window ).height()) {
            $('.content').css('width', 'calc(100vw - '+(160 + getScrollBarWidth())+'px)');
        }
    };

    //tbl-summary-stope
    $('#tbl-summary-stop').DataTable({
         language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        lengthChange: false,
        paging:   false,
        info:     false,
        responsive: true,
        ajax: {
                url: '/totalHourStoped',
                dataSrc: '',
        },
        columns: [
            { data: null,
                render: function(data, type, row){
                    if (data.stoped == 1) 
                        return '<div><div class="machine-stoped"></div> '+ data.id_machine +'</div>'
                    else
                        return data.id_machine
                }
            },
            { data: 'name'},
            { data: 'total_stoped'},
            { data: null,
                render: function(data, type, row){
                    return data.hours + ":" + data.minutes
                }
            },
            { data: null,
                render: function(data, type, row){
                    return '<button class="btn btn-secondary btn-detail-stop" onclick="detailStop(`'+ data.id_machine +'`, `'+ data.name +'`, '+ data.total_stoped+', `'+ data.hours +':'+ data.minutes +'`, '+ data.stoped+', `'+ data.problem+'`)" data-toggle="modal" data-target="#modal-detail-stop">Detalles</button>'
                }
            },
        ]
    });
}); 

//tbl-detail-stop



function detailStop(id_machine, name, total_stoped, time_stoped, stoped, problem){
    $('#machine_id_stoped').text(id_machine);
    $('#machine_name_stoped').text(name);
    $('#machine_total_stoped').text(total_stoped);
    $('#machine_time_stoped').text(time_stoped);

    if (stoped) {
        $('.box_machine_status').show();
        $('#machine_status').text('Detenido');
        $('#machine_status_description').text('...');

    }else{
        $('.box_machine_status').hide();
    }

    $('.tbl-detail-stop').DataTable().clear().destroy();

    $('.tbl-detail-stop').DataTable({
         language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        lengthChange: false,
        paging:   false,
        searching: false,
        info:     false,
        responsive: true,
        ajax: {
                url: '/detail/'+id_machine,
                dataSrc: '',
        },
        columns: [
            { data: null,
                render: function(data, type, row){
                    if (data.stoped == 1){
                        $('#machine_status_description').text(data.problem);
                        return '<div><div class="machine-stoped"></div> '+ data.problem +'</div>'
                    }else{
                        return data.problem;
                    }
                }
            },
            { data: 'hour_start'},
            { data: null,
                render: function(data, type, row){
                    if (data.hour_end == null)
                        '';
                    else
                        return data.hour_end;
                }
            },
            { data: null,
                render: function(data, type, row){
                    return data.hours + ":" + data.minutes
                }
            },
            { data: 'responsible'},
        ]
    });

}