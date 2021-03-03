let tableempleados;

document.addEventListener('DOMContentLoaded',function(){
    tableempleados = $('.tableEmpleado').DataTable({
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
            "url" : base_url+"empleados/getEmpleados",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_empleado"},
            {"data":"nombre"},
            {"data":"apellido"},
            {"data":"cedula"},
            {"data":"telefono"},
            {"data":"sueldo"},
            {"data":"nombre_contracto"},
            {"data":"estado"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });

    $(function(e) {
        "use strict";
            $(".cedula-inputmask").inputmask("9999999999"),
            $(".phone-inputmask").inputmask("(999) 999-9999")
    });
    

    let formEmpleado = document.querySelector('#formEmpleado');
    formEmpleado.addEventListener('submit', function (e){
        e.preventDefault();
        let camps = new Array();
        let campsRegex = new Array();

        let  id_empleado = document.querySelector('#id_empleado').value;
        let  nombreInput = document.querySelector('#nombre').value;
        let  apellidoInput = document.querySelector('#apellido').value;
        let  cedulaInput = document.querySelector('#cedula').value;
        let  emailInput = document.querySelector('#email').value;
        let  telefonoInput = document.querySelector('#telefono').value;
        let  sueldoInput = document.querySelector('#sueldo').value;
        let  id_contracto = document.querySelector('#id_contracto').value;
        let  estadoInput = document.querySelector('#estadoInput').value;
        camps.push(nombreInput,apellidoInput,cedulaInput,
            emailInput,telefonoInput,sueldoInput,estadoInput,id_contracto);
        campsRegex.push(nombreInput,apellidoInput)
        if (validateCamps(camps)) {
            if (isValidString(campsRegex)) {
                if(validateCedula(cedulaInput)){
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+"empleados/setEmpleado";
                    let formData = new FormData(formEmpleado);
                    request.open("POST",ajaxUrl,true);
                    request.send(formData);
                    request.onreadystatechange = function(){
                        if(request.readyState==4 && request.status == 200){
                            let objData = JSON.parse(request.responseText); 
                            if (objData.status){
                                $('#modalEmpleado').modal("hide");
                                let camps = new Array();
                                camps.push("nombre","apellido","cedula","email","telefono","sueldo")
                                camps.forEach(function(element,index){
                                    document.querySelector('#'+element).value = '';
                                })
                                mensaje("success","Exitoso",objData.msg);
                                tableempleados.ajax.reload(function(){
                                    baseAjaxEdit('.btnEditarEmpleado','emp','empleados','getEmpleado',
                                    'Actualizar el empleado',["nombre","apellido","cedula","email","telefono","sueldo"],
                                    'id_empleado','#modalEmpleado',ExistSelect = true,'id_contracto',ImagePreview = false,'');                           
                                });
                            }else{
                                mensaje("error","Error",objData.msg);
                            }
                        }
                    }
                }else{
                    return validateCedula(cedulaInput);
                }
            }else{
                return isValidString(campsRegex);
            }
        }else{
            return validateCamps(camps);
        }
    });

    setTimeout(() => {
        fntContractoEmpleado();
    }, 1000);
},false);

window.addEventListener('click',function(){
    setTimeout(function(){ 
        baseAjaxEdit('.btnEditarEmpleado','emp','empleados','getEmpleado',
        'Actualizar el empleado',["nombre","apellido","cedula","email","telefono","sueldo"],
        'id_empleado','#modalEmpleado',ExistSelect = true,'id_contracto',ImagePreview = false,'');
    },500);
})

baseAjaxEdit('.btnEditarEmpleado','emp','empleados','getEmpleado',
    'Actualizar el empleado',["nombre","apellido","cedula","email","telefono","sueldo"],
    'id_empleado','#modalEmpleado',ExistSelect = true,'id_contracto',ImagePreview = false,'');



function abrir_modal_empleado(){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    let camps = new Array();
    camps.push("nombre","apellido","cedula","email","telefono","sueldo","estadoInput","id_contracto")
    camps.forEach(function(element,index){
        document.querySelector('#'+element).value = '';
    })
    document.querySelector('#id_empleado').value="";
    document.querySelector('.text-center').innerHTML = " Guardar Registro";
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo Empleado";
    document.querySelector('#btnDisabled').style.display = 'inline-block';
    $('#modalEmpleado').modal(options);
}


function fntContractoEmpleado() {
    let ajaxUrl = base_url+"contractos/getSelectContractos";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            document.querySelector("#id_contracto").innerHTML = "<option  selected disabled='disabled'  value=''>Seleciona el contracto</option>"+request.responseText;
        }
    }

}

