let chart;

document.addEventListener('DOMContentLoaded',function(){

    fntGrahpEstadoNomina();
});


function fntGrahpEstadoNomina(){
    chart = Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Grafico | Estado Nominas'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },

        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Total',
            colorByPoint: true,
            data:[]
        }]
    });

    let array_estado = new Array();

    $.getJSON(base_url+"dashboard/graphEstadoNominas", 
        function (data) {
            data.forEach((x,y) => {
                array_estado.push(x)
                let estado_obj = chart.series[0];
                estado_obj.setData(array_estado)
            });
        }
    );
}

