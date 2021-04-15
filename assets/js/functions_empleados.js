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
            {"data":"nombre_puesto"},
            {"data":"nombre_contrato"},
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
    if(formEmpleado != null){
        formEmpleado.addEventListener('submit', (e) => {
            e.preventDefault();
            let  id_empleado = document.querySelector('#id_empleado').value;
            let  nombre_empleado = document.querySelector('#nombre').value;
            let  apellido_empleado = document.querySelector('#apellido').value;
            let  cedula_empleado = document.querySelector('#cedula').value;
            let  telefono_empleado = document.querySelector('#telefono').value;
            let  sueldo_empleado = document.querySelector('#sueldo').value;
            let  id_puesto = document.querySelector('#id_puesto').value;
            let  id_contrato = document.querySelector('#id_contrato').value;
            let  estado_empleado = document.querySelector('#estadoInput').value;
            let  validate_data = [nombre_empleado,apellido_empleado,cedula_empleado,telefono_empleado,sueldo_empleado,estado_empleado,id_contrato,id_puesto]
            let  validate_data_regex = [nombre_empleado,apellido_empleado]; 
            let  validate_data_regex_numbers = [cedula_empleado,sueldo_empleado,id_puesto,id_contrato,estado_empleado]
            if (validateEmptyFields(validate_data)) {
                if (validateInnput(validate_data_regex,regex_string) && validateInnput(validate_data_regex_numbers,regex_numbers)) {
                    if(validateCedula(cedula_empleado)){
                        (async () => {
                            try {
                                const data = new FormData(formEmpleado);
                                let options = { method: "POST", body:data}
                                let response = await fetch(base_url+"empleados/setEmpleado",options);
                                if (response.ok) {
                                    let data = await response.json();
                                    if(data.status){
                                        $('#modalEmpleado').modal("hide");
                                        let camps = new Array();
                                        camps.push("nombre","apellido","cedula","telefono","sueldo")
                                        camps.forEach(function(element,index){
                                            document.querySelector('#'+element).value = '';
                                        })
                                        mensaje("success","Exitoso",data.msg);
                                        tableempleados.ajax.reload(function(){
                                            fetchEdit('.btnEditarEmpleado','emp','empleados','getEmpleado',
                                            'Actualizar el empleado',["nombre","apellido","cedula","telefono","sueldo"],
                                            'id_empleado','#modalEmpleado',ExistSelect = true,'id_contrato',ImagePreview = false,'',ExistSelect_two = true,'id_puesto');
                                            fetchDelete('.btnEliminarEmpleado','emp','empleados',
                                            'delEmpleado','Eliminar empleado',"¿Desea eliminar este empleado?",'#modalEmpleado',tableempleados);
                                        });
                                    }else{
                                        mensaje("error","Error",data.msg);
                                    }
                                }else {
                                    mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                                }
                            } catch (err) {
                                mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                            }
                        })();
                    }else{
                        return validateCedula(cedulaInput);
                    }
                }else{
                    return validateInnput(validate_data_regex,regex_string);
                }
            }else{
                return validateEmptyFields(validate_data);
            }
        });
    }

    setTimeout(() => {
        fetchSelect('id_contrato','getSelectContratos','contratos','Seleciona el contrato');
        fetchSelect('id_puesto','getSelectPuestos','puestos','Seleciona el puesto');
    }, 1500);
},false);

window.addEventListener('click',function(){
    setTimeout(function(){ 
        fetchEdit('.btnEditarEmpleado','emp','empleados','getEmpleado',
        'Actualizar el empleado',["nombre","apellido","cedula","telefono","sueldo"],
        'id_empleado','#modalEmpleado',ExistSelect = true,'id_contrato',ImagePreview = false,'',ExistSelect_two = true,'id_puesto');
        fetchDelete('.btnEliminarEmpleado','emp','empleados',
        'delEmpleado','Eliminar empleado',"¿Desea eliminar este empleado?",'#modalEmpleado',tableempleados);
    },500);
})

fetchEdit('.btnEditarEmpleado','emp','empleados','getEmpleado',
    'Actualizar el empleado',["nombre","apellido","cedula","telefono","sueldo"],
    'id_empleado','#modalEmpleado',ExistSelect = true,'id_contrato',ImagePreview = false,'',ExistSelect_two = true,'id_puesto');


fetchDelete('.btnEliminarEmpleado','emp','empleados',
'delEmpleado','Eliminar empleado',"¿Desea eliminar este empleado?",'#modalEmpleado',tableempleados);


function abrir_modal_empleado(){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    let camps = new Array();
    camps.push("nombre","apellido","cedula","telefono","sueldo","estadoInput","id_contrato","id_puesto")
    camps.forEach(function(element,index){
        document.querySelector('#'+element).value ='';
    })
    document.querySelector('#id_empleado').value="";
    document.querySelector('.text-center').innerHTML = " Guardar Registro";
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo Empleado";
    document.querySelector('#btnDisabled').style.display = 'inline-block';
    $('#modalEmpleado').modal(options);
}


fetchSelect('id_contrato','getSelectContratos','contratos','Seleciona el contrato');
fetchSelect('id_puesto','getSelectPuestos','puestos','Seleciona el puesto');


