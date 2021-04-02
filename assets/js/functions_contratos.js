let tablecontrato;

document.addEventListener('DOMContentLoaded',function(){
    tablecontrato = $('.tableContrato').DataTable({
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
            "url" :base_url+"contratos/getContratos",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_contrato"},
            {"data":"nombre_contrato"},
            {"data":"descripcion"},
            {"data":"estado"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });

    let formContrato = document.querySelector('#formContrato');
    formContrato.addEventListener('submit', function (e) {
        e.preventDefault();        
        let camps = new Array();
        let campsRegx = new Array();
        let idContrato = document.querySelector('#id_contrato').value;
        let contratoInput = document.querySelector('#nombre_contrato').value;
        let descriInput = document.querySelector('#descripcion').value;
        let estadoInput = document.querySelector('#estadoInput').value;
        camps.push(contratoInput,descriInput,estadoInput);
        campsRegx.push(contratoInput);
        if(validateCamps(camps)){
            if(isValidString(campsRegx)){
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+"contratos/setContrato";
                let formData = new FormData(formContrato);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState==4 && request.status == 200){
                        let objData = JSON.parse(request.responseText); 
                        if (objData.status){
                            $('#modalContrato').modal("hide");
                            let idContrato = document.querySelector('#id_contrato').value = '';
                            let contratoInput = document.querySelector('#nombre_contrato').value = '';
                            let descriInput = document.querySelector('#descripcion').value = '';
                            mensaje("success","Exitoso",objData.msg);
                            document.querySelector('#csrf').value = objData.token;
                            tablecontrato.ajax.reload(function(){
                                setTimeout(function(){ 
                                    baseAjaxEdit('.btnEditarContrato','cont','contratos',
                                    'getContrato','Actualizacion de contrato',['nombre_contrato','descripcion'],
                                    'id_contrato','#modalContrato',ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')
                                    baseAjaxDelete('.btnEliminarContrato','cont','contratos','delContrato',
                                    'Eliminar contrato',"¿Desea eliminar este contrato?",'#modalContrato',tablecontrato);
                                },500);
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
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo contratos";
    document.querySelector('#btnDisabled').style.display = 'inline-block';
    let idContrato = document.querySelector('#id_contrato').value = '';
    let contratoInput = document.querySelector('#nombre_contrato').value = '';
    let descriInput = document.querySelector('#descripcion').value = '';
    let estadoInput = document.querySelector('#estadoInput').value;
    $('#modalContrato').modal(options);
}

window.addEventListener('click',function(){
    setTimeout(function(){ 
        baseAjaxEdit('.btnEditarContrato','cont','contratos','getContrato',
        'Actualizacion de contrato',['nombre_contrato','descripcion'],'id_contrato',
        '#modalContrato',ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')
        baseAjaxDelete('.btnEliminarContrato','cont','contratos','delContrato',
        'Eliminar contrato',"¿Desea eliminar este contrato?",'#modalContrato',tablecontrato);
    }, 500);
},false);

baseAjaxEdit('.btnEditarContrato','cont','contratos','getContrato','Actualizacion de contrato',
['nombre_contrato','descripcion'],'id_contrato','#modalContrato',
ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')

baseAjaxDelete('.btnEliminarContrato','cont','contratos','delContrato',
'Eliminar contrato',"¿Desea eliminar este contrato?",'#modalContrato',tablecontrato);
