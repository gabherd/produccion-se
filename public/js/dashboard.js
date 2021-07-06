var responsableCorrection = [    ['Setup', 'Maquinas'] ];
var getTotalMachineStoped = [];
var totalHoursStoped = [];
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
             totalHoursStoped.push({name: data[index].id_machine, process: data[index].name, y: parseFloat(data[index].hours + "." + data[index].minutes), hours:data[index].hours, minutes: data[index].minutes});
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
    title: 'Eficiencia setup'
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
});
