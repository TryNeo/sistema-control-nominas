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
    if(document.querySelector('#formContrato')){
        let formContrato = document.querySelector('#formContrato');
        formContrato.addEventListener('submit', (e)  => {
            e.preventDefault(); 
            let id_contrato = document.querySelector('#id_contrato').value;       
            let nombre_contrato = document.querySelector('#nombre_contrato').value;
            let descripcion_contrato  = document.querySelector('#descripcion').value;
            let estado_contrato = document.querySelector('#estadoInput').value;
            let validate_data = [nombre_contrato,descripcion_contrato,estado_contrato]
            let validate_data_regex = [nombre_contrato,descripcion_contrato];
            if(validateEmptyFields(validate_data)){
                if(validateInnput(validate_data_regex,regex_string) && validateInnput([estado_contrato],regex_numbers)){
                    (async () => {
                        try {
                            const data = new FormData(formContrato);
                            let options = { method: "POST", body:data}
                            let response = await fetch(base_url+"contratos/setContrato",options);
                            if (response.ok) {
                                let data = await response.json();
                                if(data.status){
                                    $('#modalContrato').modal("hide");
                                    id_contrato.value = '';nombre_contrato.value = '';descripcion_contrato.value='';
                                    mensaje("success","Exitoso",data.msg);
                                    tablecontrato.ajax.reload(function(){
                                        setTimeout(function(){ 
                                            fetchEdit('.btnEditarContrato','cont','contratos',
                                            'getContrato','Actualizacion de contrato',['nombre_contrato','descripcion'],
                                            'id_contrato','#modalContrato',ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')
                                            fetchDelete('.btnEliminarContrato','cont','contratos','delContrato',
                                            'Eliminar contrato',"¿Desea eliminar este contrato?",'#modalContrato',tablecontrato);
                                        },500);
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
                    return validateInnput(validate_data,regex_string)
                }
            }else{
                return validateEmptyFields(validate_data)
            }
        });
    }
});


window.addEventListener('click',function(){
    setTimeout(function(){ 
        fetchEdit('.btnEditarContrato','cont','contratos','getContrato',
        'Actualizacion de contrato',['nombre_contrato','descripcion'],'id_contrato',
        '#modalContrato',ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')
        fetchDelete('.btnEliminarContrato','cont','contratos','delContrato',
        'Eliminar contrato',"¿Desea eliminar este contrato?",'#modalContrato',tablecontrato);
    }, 500);
},false);

fetchEdit('.btnEditarContrato','cont','contratos','getContrato','Actualizacion de contrato',
['nombre_contrato','descripcion'],'id_contrato','#modalContrato',
ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')

fetchDelete('.btnEliminarContrato','cont','contratos','delContrato',
'Eliminar contrato',"¿Desea eliminar este contrato?",'#modalContrato',tablecontrato);

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
