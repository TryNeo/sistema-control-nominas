let tablenominas;
let dataNomina;
let id_nomina;

document.addEventListener('DOMContentLoaded',function(){
    id_nomina = document.querySelector('#id_nomina').value;
    dataNomina = $('#tableNominaEmpleado').DataTable({
                "pageLength": 5,
                "aProcessing":true,
                "aServerSide":true,
                "info":     false,
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "NingÃºn dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "<span class='fa fa-angle-double-left'></span>",
                        "sLast": "<span class='fa fa-angle-double-right'></span>",
                        "sNext": "<span class='fa fa-angle-right'></span>",
                        "sPrevious": "<span class='fa fa-angle-left'></span>"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                responsive:true,
                destroy : true,
                "ajax":{
                    "url" : base_url+"nominas/getNominaEmpleados/"+id_nomina,
                    "dataSrc":""
                },
                "columns":[
                    {"data":"id_detalle_nomina"},
                    {"data":"nombre"},
                    {"data":"nombre_puesto"},
                    {"data":"sueldo"},
                    {"data":"meses"},
                    {"data":"valor_total"}
                ],
                "order":[[0,"desc"]]
            });

    tablenominas = $('.tableNomina').DataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "NingÃºn dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "<span class='fa fa-angle-double-left'></span>",
                "sLast": "<span class='fa fa-angle-double-right'></span>",
                "sNext": "<span class='fa fa-angle-right'></span>",
                "sPrevious": "<span class='fa fa-angle-left'></span>"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        responsive:true,
        "ajax":{
            "url" : base_url+"nominas/getNominas",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_nomina"},
            {"data":"nombre_nomina"},
            {"data":"periodo_inicio"},
            {"data":"periodo_fin"},
            {"data":"estado_nomina"},
            {"data":"total"},
            {"data":"estado"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });

    let formNomina = document.querySelector('#formNomina');
    if(formNomina != null){
        formNomina.addEventListener('submit', function (e) {
            e.preventDefault();        
            let camps = new Array();
            let nombre_nomina = document.querySelector('#nombre_nomina').value;
            let periodo_inicio = document.querySelector('#periodo_inicio').value;
            let periodo_fin = document.querySelector('#periodo_fin').value;
            let estado_nomina = document.querySelector('#estado_nomina').value;
            let estadoInput = document.querySelector('#estadoInput').value;
            camps.push(nombre_nomina,periodo_inicio,periodo_fin,estado_nomina,estadoInput);
            if (validateCamps(camps)) {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+"nominas/setNomina";
                let formData = new FormData(formNomina);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState==4 && request.status == 200){
                        let objData = JSON.parse(request.responseText); 
                        if (objData.status){
                            $('#modalNomina').modal("hide");
                            let idNomina = document.querySelector('#id_nomina').value = '';
                            let nombre_nomina = document.querySelector('#nombre_nomina').value = '';
                            let periodo_inicio = document.querySelector('#periodo_inicio').value = '';
                            let periodo_fin = document.querySelector('#periodo_fin').value = '';
                            let estado_nomina = document.querySelector('#estado_nomina').value = '';
                            let estadoInput = document.querySelector('#estadoInput').value = '';
                            mensaje("success","Exitoso",objData.msg);
                            tablenominas.ajax.reload();
                        }else{
                            mensaje("error","Error",objData.msg);
                        }
                    }
                }
            }else{
                return validateCamps(camps);
            };
        });
    }

    $("input[name='meses_detalle']").TouchSpin({
        min: -1000000000,
        max: 1000000000,
        stepinterval: 50,
        maxboostedstep: 10000000,
        initval :0,
        postfix:"<i class='far fa-calendar-alt'></i>"
    });

    fntSetDetalleNomina();

    setTimeout(() => {
        fntSelectEmpleado();
    }, 1000);
    fntSearchEmpleado()

},false);



window.addEventListener('click',function(){
    setTimeout(function(){ 
        fntEliminarDetalle()
    }, 100);
},false);

function abrir_modal_nomina(){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    let camps = new Array();
    camps.forEach(function(element,index){
        document.querySelector('#'+element).value = '';
    })

    document.querySelector('#id_nomina').value="";
    document.querySelector('.text-center').innerHTML = " Guardar Registro";
    document.querySelector('#modalTitle').innerHTML = "Generar nueva Nomina";
    $('#modalNomina').modal(options);
}

function fntSetDetalleNomina(){
    let formDetalleNomina = document.querySelector('#formDetalleNomina');
    if(formDetalleNomina != null){
        formDetalleNomina.addEventListener('submit', function (e) {
            e.preventDefault();
            let id_nomina = document.querySelector('#id_nomina').value;        
            let nombre_nomina = document.querySelector('#nombre_nomina').value;
            let estado_nomina = document.querySelector('#estado_nomina').value;
            let meses_detalle = document.querySelector('#meses_detalle').value;
            if(meses_detalle >= 1){
                if(nombre_nomina === ""){
                    mensaje("error","Error","Ingrese el nombre la nomina");
                }else{
                    $.getJSON(base_url+"nominas/getNominaEmpleados/"+id_nomina,function(data){
                        if(!data.length){
                            mensaje("error","Error","Ingrese los empleados respectivos de la nomina");
                        }else{
                            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                            let ajaxUrl = base_url+"nominas/setDetalleGeneral";
                            let formData = new FormData(formDetalleNomina);
                            request.open("POST",ajaxUrl,true);
                            request.send(formData);
                            request.onreadystatechange = function(){
                                if(request.readyState==4 && request.status == 200){
                                    let objData = JSON.parse(request.responseText); 
                                    if (objData.status){
                                        mensaje("success","Exitoso",objData.msg);
                                        dataNomina.ajax.reload();
                                        let meses_detalle = document.querySelector('#meses_detalle').value = 0;
                                    }else{
                                        mensaje("error","Error",objData.msg);
                                    }
                                }
                            }
                        }
                    });
                }
            }else{
                mensaje("error","Error","Ingrese un numero de meses valido");
            }
        });
    }
}


function fntSelectEmpleado(){
    let ajaxUrl = base_url+"nominas/getNominaEmpleado";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            document.querySelector("#SearchEmpl").innerHTML = "<option  selected disabled='disabled'  value=''>Buscar ...</option>"+request.responseText;
        }
    }
}


function fntSearchEmpleado(){
    $('#SearchEmpl').select2({
        theme: 'bootstrap4',
    }).on('select2:select',function(e){
        e.preventDefault();
        let meses_detalle = document.querySelector('#meses_detalle').value;
        if(meses_detalle>=1){
            let  id_empleado = document.querySelector('#SearchEmpl').value;
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+"nominas/getSearchNominaEmpleado/"+id_empleado;
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status == 200){
                    let objData = JSON.parse(request.responseText); 
                    if (objData.status){
                        let request_two =  (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                        let ajaxUrl_two = base_url+"nominas/setDetalleNomina";
                        let formData = new FormData();
                        formData.append("id_empleado",objData.msg['id_empleado']);
                        formData.append("id_nomina",id_nomina);
                        request_two.open("POST",ajaxUrl_two,true);
                        request_two.send(formData);
                        request_two.onreadystatechange = function(){
                            if(request_two.readyState==4 && request_two.status == 200){
                                let objData = JSON.parse(request_two.responseText); 
                                if (objData.status){
                                    let array_total = new Array();
                                    let meses = document.querySelector('#meses_detalle').value;
                                    dataNomina.ajax.reload(function(){
                                        fntSelectEmpleado();
                                        fntEliminarDetalle()
                                    });
                                    $.getJSON(base_url+"nominas/getNominaEmpleados/"+id_nomina,function(data){
                                        data.forEach((key,value) => {
                                            array_total.push(key['sueldo'])
                                            let total = document.querySelector('#total').value = array_total.reduce((acum,total)=> 
                                            parseInt(acum)+parseInt(total))*meses;
                                        })
                                    }) ;
                                }else{
                                    mensaje("error","Error",objData.msg);
                                }
                            }
                        }
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            } 
        }else{
            mensaje("error","Error","Ingrese la cantidad de meses primero");
        }
    });
}


function fntEliminarDetalle(){
    let btnEliminarDetalle = document.querySelectorAll('.btnEliminarDetalle');
    btnEliminarDetalle.forEach(function(btnEliminarDetalle){
        btnEliminarDetalle.addEventListener('click',function(e){
            e.preventDefault();
            let id = this.getAttribute('det');
            let id_nomina = document.querySelector('#id_nomina').value;
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+"nominas/delDetalleEmpleado";
            let formData = new FormData();
            formData.append("id_detalle_nomina",id);
            formData.append("id_nomina",id_nomina);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status == 200){
                    let objData = JSON.parse(request.responseText); 
                    if (objData.status){
                        let array_total = new Array();
                        dataNomina.ajax.reload(function(){
                            fntSelectEmpleado();
                            fntEliminarDetalle()
                        });

                        $.getJSON(base_url+"nominas/getNominaEmpleados/"+id_nomina,function(data){
                            data.forEach((key,value) => {
                                array_total.push(key['valor_total'])
                            })
                            let total = document.querySelector('#total').value = (array_total.reduce((a, b) => parseInt(a) + parseInt(b),0) === 0) ? 0 : array_total.reduce((a, b) => parseInt(a) + parseInt(b),0) ;
                        }) ;
                        let meses_detalle = document.querySelector('#meses_detalle').value = 0;

                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
        });
    });
}