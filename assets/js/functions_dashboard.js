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
    fntGrahpNominasEmpleados();
});

async function fntGrahpNominaAgno(){
    try{
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
        let options_agno = { method:"GET"};
        let response_agno = await fetch(base_url+"dashboard/grahpNominaTotal",options_agno);
        if(response_agno.ok){
            let data_agno = await response_agno.json();
            data_agno.forEach((x,y) => {
                array_agno.push([x.nombre_nomina,parseFloat(x.total)])
                let agno_obj = charg_agno.series[0];
                agno_obj.setData(array_agno)
            });
        }else{
            mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion");
        }
    } catch (err) {
        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion");
    }

}

async function fntGrahpNominaTotales(){
    try{
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
        let options_estado = { method:"GET"};
        let response_empleados_total = await fetch(base_url+"dashboard/grahpNominaTotal",options_estado);
        if(response_empleados_total.ok){
            let data = await response_empleados_total.json();
            data.forEach((x,y) => {
                array_total.push([x.nombre_nomina,parseInt(x.total)])
                let total_obj = chart_total.series[0];
                total_obj.setData(array_total)
            });
        }else{
            mensaje("error","Error de Carga","Oops hubo un error al cargar los datos");
        }
        
    } catch (err) {
        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion");
    }
}

async function fntGrahpNominaEstado(){
    try{
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
        let options_estado = { method:"GET"};
        let response_empleados_estado = await fetch(base_url+"dashboard/graphEstadoNominas",options_estado);
        if(response_empleados_estado.ok){
            let data_empleados_estado = await response_empleados_estado.json();
            data_empleados_estado.forEach((x,y) => {
                array_estado.push(x)
                let estado_obj = chart.series[0];
                estado_obj.setData(array_estado)
            });
        }else{
            mensaje("error","Error de Carga","Oops hubo un error al cargar los datos");
        }
    } catch (err) {
        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion");
    }
}

async function fntGrahpNominasEmpleados(){
    try{

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

        
        let array_empleados_total = new Array();
        let options_empleados_total = { method:"GET"}
        let response_empleados_total = await fetch(base_url+"dashboard/grahpEmpleadosTotal",options_empleados_total);
        if(response_empleados_total.ok){
            let data_empleados_total = await response_empleados_total.json();
            data_empleados_total.forEach((empl) => {
                empl['y'] = parseFloat(empl['y']);
                array_empleados_total.push(empl)
            });
            let empleados_obj = chart_empleados.series[0];
            empleados_obj.setData(array_empleados_total);
        }else{
            mensaje("error","Error de Carga","Oops hubo un error al cargar los datos");
        }

        let options_empleados_gen = { method:"GET"}
        let response_empleados_gen = await fetch(base_url+"dashboard/grahpEmpleadosGeneral",options_empleados_gen);
        if(response_empleados_gen.ok){
            let data_empleados_gen = await response_empleados_gen.json();
            data_empleados_gen.forEach((empl_data) => {
                let array_data = [];
                empl_data['data'].forEach((value) => {
                    array_data.push([value['nombre_nomina'],parseFloat(value['valor_total'])]);
                    empl_data['data'] = array_data;
                });
                chart_empleados.options.drilldown.series.push(empl_data);
            });
        }else{
            mensaje("error","Error de Carga","Oops hubo un error al cargar los datos");
        }

    } catch (err) {
        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion");
    }

}

async function fntEmpladosRecientes(){
    try {
        let options = { method: "GET"};
        let response = await fetch(base_url+"dashboard/getEmpleadosNow",options);
        if (response.ok) {
            let data = await response.text();
            if(document.querySelector("#empleadosNow") !=null){
                document.querySelector(
                    "#empleadosNow"
                ).innerHTML = data;
            }
        } else {
            mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
        }  
    } catch (err) {
        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
    }
}

async function fntNominasRecientes(){
    try {
        let options = { method: "GET"};
        let response = await fetch(base_url+"dashboard/getNominasNow",options);
        if (response.ok) {
            let data = await response.text();
            if(document.querySelector("#nominasNow") !=null){
                document.querySelector(
                    "#nominasNow"
                ).innerHTML = data;
            }
        } else {
            mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
        }
    } catch (err) {
        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
    }
}