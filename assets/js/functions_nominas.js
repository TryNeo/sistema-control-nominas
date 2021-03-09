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