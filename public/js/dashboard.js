var responsableCorrection = [    ['Setup', 'Maquinas'] ];
var QtyMachineStoped = {labels: [], data: []};
var ctx = document.getElementById('myChart').getContext('2d');
google.charts.load('current', {'packages':['corechart']});


getMachineStoped();
getNameResponsable();
chartHourStop();
qtyMachineStoped();


$(document).ready(function(){
}); 

function getMachineStoped(){
    $.get( "qtyMachineStoped", function( data ) {
        $('#machine-stoped').text(data);
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
              google.charts.setOnLoadCallback(chartSetup);
        }
    });
}

function qtyMachineStoped(){
    /*$.ajax({                                            
        url: 'qtyStopedByMachine',                        
        dataType: 'json',
        async:false,                    
        success: function(data)          
        {   

           for(index in data){
             QtyMachineStoped.push({name: data[index].id_machine, y: data[index].total});
            }   
        },
        complete: function (data) {
            chartQtyStoped();
        }
    });*/
    $.ajax({                                            
        url: 'qtyStopedByMachine',                        
        dataType: 'json',
        async:false,                    
        success: function(data)          
        {   

           for(index in data){
             QtyMachineStoped.labels.push(data[index].id_machine);
             QtyMachineStoped.data.push(data[index].total);
            }   
        },
        complete: function (data) {
            chartQtyStoped();
        }
    });

}

//obtiene la cantidad de horas que se han detenido las maquinas
function chartHourStop(){
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
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> Horas<br/>'
        },
        series: [
            {
                name: "Maquina",
                colorByPoint: true,
                data: [
                    {
                        name: "CA-4006",
                        y: 5,
                    },
                    {
                        name: "CA-3192",
                        y: 7,
                    },
                    {
                        name: "CA-0307",
                        y: 1,
                    },
                    {
                        name: "CA-1792",
                        y: 0.3,
                    },
                    {
                        name: "CA-2134",
                        y: 0.2,
                    },
                    {
                        name: "CA-2017",
                        y: 11,
                    },
                    {
                        name: "CA-1345",
                        y: 5,
                    }
                ]
            }
        ],
    });
}

//obtiene cual setup tranaja mas
function chartSetup() {

  var data = google.visualization.arrayToDataTable( responsableCorrection );

  var options = {
    title: 'Eficiencia setup'
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

  chart.draw(data, options);
}

//obtiene cuantas veces se han parado las maquinas
function chartQtyStoped(){
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: QtyMachineStoped.labels,
            datasets: [{
                label: 'Total de paros',
                data: QtyMachineStoped.data,
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                     ticks: {
                        stepSize: 1,
                    },
                    suggestedMax:  Math.max(...QtyMachineStoped.data) + 1,
                }
            },
            plugins: {
                legend: {
                    display: false
                }, 
                title: {
                    display: true,
                    text: 'Cantidad de paros por maquina'
                }
            }
        }
    });
    /*Highcharts.chart('myChart', {
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
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> paros<br/>'
        },
        series: [
            {
                name: "Cantidad de paros",
                colorByPoint: true,
                data: QtyMachineStoped
            }
        ],
    });*/
}

//adapta el ancho del cocumento por el scroll lateral
$(document).ready(function(){
    if ($( window ).width() >= 900) {
        if ($( document ).height() > $( window ).height()) {
            $('.content').css('width', 'calc(100vw - '+(160 + getScrollBarWidth())+'px)');
        }
    };
});
