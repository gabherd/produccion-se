var responsableCorrection = [    ['Setup', 'Maquinas'] ];
var getTotalMachineStoped = [];
var totalHoursStoped = [];
var colors = ['#03A9F4', '#FF9800', '#8BC34A', '#607D8B', '#7C4DFF', '#00BCD4', '#CDDC39', '#FF5722', '#E040FB', '#795548', '#D3C43F', '#009688', '#9E9E9E', '#FFC107', '#4CAF50', '#448AFF', '#536DFE', '#FF4081', '#FF5252'];
google.charts.load('current', {'packages':['corechart']});


getMachineNotRepaired();
getNameResponsable();
getTotalStopByMachine();
getTotalHourStoped();

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

function getTotalHourStoped(){
    $.ajax({                                            
        url: 'totalHourStoped',                        
        dataType: 'json',
        async:false,                    
        success: function(data)          
        {   
            for(index in data){
                var id_machine = data[index].id_machine
                var name_process = data[index].name
                var total_stoped = data[index].total_stoped
                var full_time = parseFloat(data[index].hours + "." + data[index].minutes)
                var hours = data[index].hours
                var minutes = data[index].minutes


                totalHoursStoped.push({name: id_machine, 
                                        process: name_process, 
                                        y: full_time, 
                                        hours: hours, 
                                        minutes: minutes});

            }   
        },
        complete: function (data) {
            chartTotalStopByMachine();
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

//obtiene la cantidad de horas que se han detenido las maquinas
function chartTotalStopByMachine(){
    // Create the chart
    Highcharts.chart('hour-stop', {
        chart: {
            type: 'column'
        },
        colors: colors,
        title: {
            text: 'Total de horas de paros'
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
                text: 'Horas de paros'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.0f}'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<b>Maquina: </b><span style="color:{point.color}">{point.name}</span> <br>'+
                         '<b>Proceso:</b> {point.process} <br>'+
                         '<b>Tiempo:</b>  {point.hours}:{point.minutes} <br>'
        },
        series: [
            {
                name: "Paro de maquina",
                colorByPoint: true,
                data:  totalHoursStoped 
                /* 
                totalHoursStoped structure
                {
                        name: "CA-4006",
                        process: "BIM",
                        y: 5,
                }*/
            }
        ],
    });
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
            { data: 'id_machine'},
            { data: 'name'},
            { data: 'total_stoped'},
            { data: null,
                render: function(data, type, row){
                    return data.hours + ':' + data.minutes
                }
            },
        ]
    });
}); 
