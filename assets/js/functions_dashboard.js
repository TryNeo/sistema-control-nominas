let chart;
let chart_total;
let chart_agno;
document.addEventListener('DOMContentLoaded',function(){

    fntGrahpNominaEstado();
    fntGrahpNominaTotales()
    fntGrahpNominaAgno();
});

function fntGrahpNominaAgno(){
    let fecha = new Date();
    let agno = fecha.getFullYear();

    charg_agno = Highcharts.chart('AgnoGrahp', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total de Nominas respectivas en el año '+agno
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Roboto, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total del Año'+agno
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Total en el año '+agno+': <b>{point.y}</b>'
        },
        series: [{
            name: 'Population',
            data: [
                
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });

    let array_agno = new Array();

    $.getJSON(base_url+"dashboard/grahpNominaTotal", 
        function (data) {
            data.forEach((x,y) => {
                array_agno.push([x.nombre_nomina,parseFloat(x.total)])
                let agno_obj = charg_agno.series[0];
                agno_obj.setData(array_agno)
            });
        }
    );
}


function fntGrahpNominaTotales(){
    chart_total = Highcharts.chart('totalGrahp', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Grafico | Total de Nominas'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Total nomina',
            data: []
        }]
    }); 

    let array_total = new Array();

    $.getJSON(base_url+"dashboard/grahpNominaTotal", 
        function (data) {
            data.forEach((x,y) => {
                array_total.push([x.nombre_nomina,parseInt(x.total)])
                let total_obj = chart_total.series[0];
                total_obj.setData(array_total)
            });
        }
    );
}


function fntGrahpNominaEstado(){
    chart = Highcharts.chart('estadoGrahp', {
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


