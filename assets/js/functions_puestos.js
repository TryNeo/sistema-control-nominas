let tablepuesto;


document.addEventListener('DOMContentLoaded',function(){
    tablepuesto = $('.tablePuesto').DataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningun dato disponible en esta tabla",
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
            "url" :base_url+"puestos/getPuestos",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_puesto"},
            {"data":"nombre_puesto"},
            {"data":"descripcion"},
            {"data":"estado"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });

    let formPuesto = document.querySelector('#formPuesto');
    formPuesto.addEventListener('submit', function (e) {
        e.preventDefault();        
        let camps = new Array();
        let campsRegx = new Array();
        let puestoInput = document.querySelector('#nombre_puesto').value;
        let descriInput = document.querySelector('#descripcion').value;
        let estadoInput = document.querySelector('#estadoInput').value;
        camps.push(puestoInput,descriInput,estadoInput);
        campsRegx.push(puestoInput);
        if(validateCamps(camps)){
            if(isValidString(campsRegx)){
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+"puestos/setPuesto";
                let formData = new FormData(formContracto);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState==4 && request.status == 200){
                        let objData = JSON.parse(request.responseText); 
                        if (objData.status){
                            $('#modalPuesto').modal("hide");
                            let id_puesto = document.querySelector('#id_puesto').value = '';
                            let puestoInput = document.querySelector('#nombre_puesto').value = '';
                            let descriInput = document.querySelector('#descripcion').value = '';
                            mensaje("success","Exitoso",objData.msg);
                            tablepuesto.ajax.reload(function(){
                                setTimeout(function(){ 
                                    baseAjaxEdit('.btnEditarPuesto','puest','puestos','getPuesto','Actualizacion de puesto',
                                    ['nombre_puesto','descripcion'],'id_puesto','#modalPuesto',
                                    ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')
                                    baseAjaxDelete('.btnEliminarPuesto','puest','puestos','delPuesto',
                                    'Eliminar puesto',"¿Desea eliminar este puesto?",'#modalPuesto',tablepuesto);
                                }, 500);
                            });
                        }else{
                            mensaje("error","Error",objData.msg);
                        }
                    }
                }
            }else{
                return isValidString(campsRegx);
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
    let idPuesto = document.querySelector('#id_puesto').value = '';
    let ṕuestoInput = document.querySelector('#nombre_puesto').value = '';
    let descriInput = document.querySelector('#descripcion').value = '';
    let estadoInput = document.querySelector('#estadoInput').value;
    $('#modalPuesto').modal(options);
}


window.addEventListener('click',function(){
    setTimeout(function(){ 
        baseAjaxEdit('.btnEditarPuesto','puest','puestos','getPuesto','Actualizacion de puesto',
        ['nombre_puesto','descripcion'],'id_puesto','#modalPuesto',
        ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')
        baseAjaxDelete('.btnEliminarPuesto','puest','puestos','delPuesto',
        'Eliminar puesto',"¿Desea eliminar este puesto?",'#modalPuesto',tablepuesto);
    }, 500);
},false);


baseAjaxEdit('.btnEditarPuesto','puest','puestos','getPuesto','Actualizacion de puesto',
['nombre_puesto','descripcion'],'id_puesto','#modalPuesto',
ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')

baseAjaxDelete('.btnEliminarPuesto','puest','puestos','delPuesto',
'Eliminar puesto',"¿Desea eliminar este puesto?",'#modalPuesto',tablepuesto);






