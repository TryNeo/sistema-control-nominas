let tablenominas;
let dataNomina;


document.addEventListener('DOMContentLoaded',function(){

    dataNomina = {
        data:{
            empleados : []
        },
        list: function(){
            $('#tableNominaEmpleado').DataTable({
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
                destroy : true,
                "data" : this.data.empleados,
                "columns":[
                    {"data":"id_empleado"},
                    {"data":"nombre"},
                    {"data":"apellido"}
                ],
                "order":[[0,"desc"]]
            });
        }
    };

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
            {"data":"nota"},
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

    setTimeout(() => {
        fntSelectEmpleado();
    }, 1000);
    fntSearchEmpleado()
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


function fntSelectEmpleado(){
    let ajaxUrl = base_url+"nominas/getNominaEmpleado";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            document.querySelector("#SearchEmpl").innerHTML = "<option  selected disabled='disabled'  value=''>Selecione el empleado</option>"+request.responseText;
        }
    }
}



function fntSearchEmpleado(){
    $('#SearchEmpl').select2().on('select2:select',function(e){
        e.preventDefault();
        let  id_empleado = document.querySelector('#SearchEmpl').value;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+"nominas/getSearchNominaEmpleado/"+id_empleado;
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState==4 && request.status == 200){
                let objData = JSON.parse(request.responseText); 
                if (objData.status){
                    dataNomina.data.empleados.push(objData.msg);
                    dataNomina.list();
                }else{
                    mensaje("error","Error",objData.msg);
                }
            }
        } 
    });
}
