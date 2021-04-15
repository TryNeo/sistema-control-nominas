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
                columnDefs:[
                    {
                        targets:[4],
                        class:"text-center",
                        orderable:false,
                        render:function(data,type,row){
                            return '<input type="text" name="meses_det" id="meses_det" class="form-control" value="'+row.meses+'" autocomplete="Off">'
                        }
                    }
                ],
                "rowCallback": function(row,data,dislayNum,displayIndex,dataIndex){
                    $(row).find('input[name="meses_det"]').TouchSpin({
                        min: 1,
                        max: 1000000000,
                        step: 1,
                        initval :0,
                    }).on('change', function(){
                        let meses =  $(this).val();
                        let total = meses*parseInt(data.sueldo);
                        let detalle_nomina = data.id_detalle_nomina;
                        let id_detalle_nomina = detalle_nomina.split(' ')[32].split('det=')[1].split("><i")[0]
                        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                        let ajaxUrl = base_url+"nominas/setDetalleMesesTotal";
                        let formData = new FormData();
                        formData.append("id_detalle_nomina",id_detalle_nomina);
                        formData.append("meses",meses);
                        formData.append("total",total);
                        request.open("POST",ajaxUrl,true);
                        request.send(formData);
                        request.onreadystatechange = function(){
                            if(request.readyState==4 && request.status == 200){
                                let objData = JSON.parse(request.responseText); 
                                if (objData.status){
                                    dataNomina.ajax.reload(function(){
                                        setTimeout(function(){ 
                                            fntEliminarDetalle()
                                        }, 1000);
                                    });
                                    $.getJSON(base_url+"nominas/getNominaEmpleados/"+id_nomina,function(data){
                                        if(!data.length){
                                            mensaje("error","Error","Ingrese los empleados respectivos de la nomina");
                                        }else{
                                            let valores_total = new Array();
                                            data.forEach((element) => {
                                                valores_total.push(element['valor_total'])
                                            });
                                            let total =valores_total.reduce((acum,total)=> parseInt(acum)+parseInt(total));
                                            document.querySelector('#total').value = total;
                                        }
                                        
                                    });
                                }else{
                                    mensaje("error","Error",objData.msg);
                                }
                            }
                        }
                    });

                
                },
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
            let nombre_nomina = document.querySelector('#nombre_nomina').value;
            let periodo_inicio = document.querySelector('#periodo_inicio').value;
            let periodo_fin = document.querySelector('#periodo_fin').value;
            let estado_nomina = document.querySelector('#estado_nomina').value;
            let estado = document.querySelector('#estadoInput').value;
            let validate_data = [nombre_nomina,periodo_inicio,periodo_fin,estado_nomina,estado];
            if (validateEmptyFields(validate_data)) {
                if(validateInnput([nombre_nomina],regex_string) && 
                    validateInnput([estado_nomina,estado],regex_numbers)
                    ){
                    (async () => {
                        try {
                            const data = new FormData(formNomina);
                            let options = { method: "POST", body:data}
                            let response = await fetch(base_url+"nominas/setNomina",options);
                            if (response.ok) {
                                let data = await response.json();
                                if (data.status){
                                    $('#modalNomina').modal("hide");
                                    let idNomina = document.querySelector('#id_nomina').value = '';
                                    nombre_nomina.value = '';periodo_inicio.value = '';periodo_fin.value = '';estado_nomina.value = '';
                                    estado.value = '';
                                    mensaje("success","Exitoso",data.msg);
                                    tablenominas.ajax.reload(function(){
                                        setTimeout(function(){ 
                                            fetchDelete('.btnEliminarNomina','nom','nominas','delNomina',
                                            'Eliminar nomina',"¿Desea eliminar esta nomina?",'#modalNomina',tablenominas);
                                        },500)
                                    });
                                    mensaje("success","Exitoso",data.msg);
                                }else{
                                    mensaje("error","Error",data.msg);
                                }
                            } else {
                                mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                            }
                        } catch (err) {
                            mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                        }
                    })();
                        console.log("yes")
                }else{
                    return  validateInnput([nombre_nomina],regex_string),
                    validateInnput([estado_nomina,estado],regex_numbers);
                }
            }else{
                return validateEmptyFields(validate_data);
            };
        });
    }

    fntSetDetalleNomina();
    fntSearchEmpleado();

    
},false);

window.addEventListener('load',function(){
    setTimeout(function(){ 
        fntEliminarDetalle()
    }, 1000);
},false);

window.addEventListener('click',function(){
    setTimeout(function(){ 
        fetchDelete('.btnEliminarNomina','nom','nominas','delNomina',
        'Eliminar nomina',"¿Desea eliminar esta nomina?",'#modalNomina',tablenominas);
    },500)
 
})

fetchDelete('.btnEliminarNomina','nom','nominas','delNomina',
'Eliminar nomina',"¿Desea eliminar esta nomina?",'#modalNomina',tablenominas);


function formatRepo (repo) {
    if (repo.loading) {
        return repo.text;
    }

    var option = $(
        '<div class="wrapper container">'+
            '<div class="row">'
                +'<div class="col-lg-8">'
                +'<p style="margin-bottom:0;">'
                    +'<b>Nombre y Apellido: </b>'+repo.text+' '+repo.apellido+'<br>'
                    +'<b>Cargo: </b>'+repo.puesto+'<br>'
                    +'<b>Sueldo:$ </b>'+repo.sueldo
                +'</p>'
                +'</div>'
            +'</div>'
        +'</div>'
    )

    return option;
}

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
            if(nombre_nomina === ""){
                    mensaje("error","Error","Ingrese el nombre la nomina");
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
                            dataNomina.ajax.reload(function(){
                                setTimeout(function(){ 
                                    fntEliminarDetalle()
                                }, 1000);
                            });
                        }else{
                            mensaje("error","Error",objData.msg);
                        }
                    }
                }
            }
        });
    }
}

function fntSearchEmpleado(){
    $('#SearchEmpl').select2({
        theme:'bootstrap4',
        language:'es',
        allowClear:true,
        ajax: {
            url: base_url+"nominas/getNominaEmpleado",
            type: "POST",
            dataType: 'json',
            delay:250,
            data: function (params) {
                let queryParameters = {
                    search: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        placeholder:"Buscar ...",
        templateResult: formatRepo,
    }).on('select2:select',function(e){
        e.preventDefault();
        let data = e.params.data;
        let  id_empleado = data.id;
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
                    $('#SearchEmpl').val('');
                    $('#SearchEmpl').trigger('change.select2');
                    formData.append("id_empleado",objData.msg['id_empleado']);
                    formData.append("id_nomina",id_nomina);
                    request_two.open("POST",ajaxUrl_two,true);
                    request_two.send(formData);
                    request_two.onreadystatechange = function(){
                        if(request_two.readyState==4 && request_two.status == 200){
                            let objData = JSON.parse(request_two.responseText); 
                            if (objData.status){
                                dataNomina.ajax.reload(function(){
                                    setTimeout(function(){ 
                                        fntEliminarDetalle()
                                    }, 1000);
                                
                                });

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
                            setTimeout(function(){ 
                                fntEliminarDetalle()
                            }, 1000);

                        });

                        $.getJSON(base_url+"nominas/getNominaEmpleados/"+id_nomina,function(data){
                            data.forEach((key,value) => {
                                array_total.push(key['valor_total'])
                            })
                            let total = document.querySelector('#total').value = (array_total.reduce((a, b) => parseInt(a) + parseInt(b),0) === 0) ? 0 : array_total.reduce((a, b) => parseInt(a) + parseInt(b),0) ;
                        }) ;
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
        });
    });
}

function abrir_modal_reporte_detalle(idNomina){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    $('#modalReporteDetalle').modal(options);
    document.getElementById("pdfdetallenomina").src = base_url+"nominas/reporteDetalle/"+parseInt(idNomina)+"#toolbar=0";
    document.getElementById("dowloadpdf").href = base_url+"nominas/reporteDetalle/"+parseInt(idNomina);
}