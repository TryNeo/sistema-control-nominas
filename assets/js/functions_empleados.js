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
            $(".cedula-inputmask").inputmask("999999999-9"),
            $(".phone-inputmask").inputmask("(999) 999-9999")
    });
    

    let formEmpleado = document.querySelector('#formEmpleado');
    formEmpleado.addEventListener('submit', function (e){
        e.preventDefault();
        let camps = new Array();
        let nombreInput = document.querySelector('#cedula').value;
        console.log(nombreInput);
    });


},false);









function abrir_modal_empleado(){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    document.querySelector('#id_empleado').value="";
    document.querySelector('.text-center').innerHTML = " Guardar Registro";
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo Empleado";
    document.querySelector('#btnDisabled').style.display = 'inline-block';
    $('#modalEmpleado').modal(options);
}