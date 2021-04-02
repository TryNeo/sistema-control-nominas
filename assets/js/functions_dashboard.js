let chart;
let chart_total;
let chart_agno;
let chart_empleados;
document.addEventListener('DOMContentLoaded',function(){

    fntGrahpNominaEstado();
    fntGrahpNominaTotales()
    fntGrahpNominaAgno();
    fntNominasRecientes();
    fntEmpladosRecientes();
    setTimeout(() => {
        fntGrahpNominasEmpleados();
    }, 500);
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
            pointFormat: '{series.name}: <b>{point.y}</b>'
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

function fntGrahpNominasEmpleados(){
    let fecha = new Date();
    let agno = fecha.getFullYear();

    chart_empleados = Highcharts.chart('empleadosGrahp', {
            chart: {
                type: 'column'
            },

            title: {
                text: 'Empleados con Nominas y su respectiva ganacia general en el año '+agno
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
                    text: 'Total de empleados con nominas respectivas'
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
                        format: '{point.y}'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span>{point.name}</span>: <b>{point.y}</b> total<br/>'
            },
            series: [
                {
                    name: "Empleado",
                    colorByPoint: true,
                    data: []
                }
            ],
            drilldown: {
                series: []
            }
        });

    let array_empleados_total = new Array()
    $.getJSON(base_url+"dashboard/grahpEmpleadosTotal", 
        function (data) {
            data.forEach((empl) => {
                empl['y'] = parseFloat(empl['y']);
                array_empleados_total.push(empl)
                let empleados_obj = chart_empleados.series[0];
                empleados_obj.setData(array_empleados_total);
            });
        }
    );
    
    let array_empleados_data = new Array();
    $.getJSON(base_url+"dashboard/grahpEmpleadosGeneral", 
        function (data) {
            data.forEach((empl_data) => {
                let array_data = [];
                empl_data['data'].forEach((value) => {
                    array_data.push([value['nombre_nomina'],parseFloat(value['valor_total'])]);
                    empl_data['data'] = array_data;
                });
                chart_empleados.options.drilldown.series.push(empl_data);
            });
        }
    );

}

function fntEmpladosRecientes(){
    let ajaxUrl = base_url+"dashboard/getEmpleadosNow";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            if(document.querySelector("#empleadosNow") !=null){
                document.querySelector(
                    "#empleadosNow"
                ).innerHTML = request.responseText;
            }
        }
    }
}

function fntNominasRecientes(){
    let ajaxUrl = base_url+"dashboard/getNominasNow";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            if(document.querySelector("#nominasNow") !=null){
                document.querySelector(
                    "#nominasNow"
                ).innerHTML = request.responseText;
            }
        }
    }
}