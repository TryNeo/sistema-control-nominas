let tablecontracto;

document.addEventListener('DOMContentLoaded',function(){
    tablecontracto = $('.tableContracto').DataTable({
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
            "url" :base_url+"contractos/getContractos",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_contracto"},
            {"data":"nombre_contracto"},
            {"data":"descripcion"},
            {"data":"estado"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });

    let formContracto = document.querySelector('#formContracto');
    formContracto.addEventListener('submit', function (e) {
        e.preventDefault();        
        let camps = new Array();
        let idContracto = document.querySelector('#id_contracto').value;
        let contractoInput = document.querySelector('#nombre_contracto').value;
        let descriInput = document.querySelector('#descripcion').value;
        let estadoInput = document.querySelector('#estadoInput').value;
        camps.push(contractoInput,descriInput,estadoInput);
        if(validateCamps(camps)){
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+"contractos/setContracto";
            let formData = new FormData(formContracto);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status == 200){
                    let objData = JSON.parse(request.responseText); 
                    if (objData.status){
                        $('#modalContracto').modal("hide");
                        let idContracto = document.querySelector('#id_contracto').value = '';
                        let contractoInput = document.querySelector('#nombre_contracto').value = '';
                        let descriInput = document.querySelector('#descripcion').value = '';
                        mensaje("success","Exitoso",objData.msg);
                        tablecontracto.ajax.reload();
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
        }else{
            return validateCamps(camps);
        }
    });

});



function abrir_modal(){
    var options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    document.querySelector('.text-center').innerHTML = " Guardar Registro";
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo contractos";
    document.querySelector('#btnDisabled').style.display = 'inline-block';
    let idContracto = document.querySelector('#id_contracto').value = '';
    let contractoInput = document.querySelector('#nombre_contracto').value = '';
    let descriInput = document.querySelector('#descripcion').value = '';
    let estadoInput = document.querySelector('#estadoInput').value;
    $('#modalContracto').modal(options);
}
