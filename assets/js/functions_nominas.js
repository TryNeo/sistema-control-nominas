let tablenominas;

document.addEventListener('DOMContentLoaded',function(){
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
            "url" : base_url,
            "dataSrc":""
        },
        "columns":[
            {"data":"id_nomina"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });

    let formNomina = document.querySelector('#formNomina');
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
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
        }else{
            return validateCamps(camps);
        };
    });

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