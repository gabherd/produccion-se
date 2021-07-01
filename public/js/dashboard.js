var ctx = document.getElementById('myChart').getContext('2d');
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Create the chart
Highcharts.chart('hour-stop', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Browser market shares. January, 2018'
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
        title: {
            text: 'Total percent market share'
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
                format: '{point.y:.1f}'
            }
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },
    series: [
        {
            name: "Browsers",
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


function drawChart() {

  var data = google.visualization.arrayToDataTable([
    ['Setup', 'Maquinas'],
    ['Ernesto',     5],
    ['Juan',      2],
    ['Uriel',  2],
    ['Marcos', 2],
  ]);

  var options = {
    title: 'Eficiencia'
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

  chart.draw(data, options);
}


var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
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
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});


//adapta el ancho del cocumento por el scroll lateral
$(document).ready(function(){
    if ($( document ).height() > $( window ).height()) {
        $('.content').css('width', 'calc(100vw - '+(160 + getScrollBarWidth())+'px)');
    }
});
