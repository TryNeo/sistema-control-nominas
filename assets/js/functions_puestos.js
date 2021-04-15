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
        let nombre_puesto = document.querySelector('#nombre_puesto').value;
        let descripcion_puesto = document.querySelector('#descripcion').value;
        let estado_puesto = document.querySelector('#estadoInput').value;
        if(validateEmptyFields([nombre_puesto,descripcion_puesto,estado_puesto])){
            if(validateInnput([nombre_puesto,descripcion_puesto],regex_string)){
                (async () => {
                    try {
                        const data = new FormData(formPuesto);
                        let options = { method: "POST", body:data}
                        let response = await fetch(base_url+"puestos/setPuesto",options);
                        if (response.ok) {
                            let data = await response.json();
                            if(data.status){
                                $('#modalPuesto').modal("hide");
                                let id_puesto = document.querySelector('#id_puesto').value = '';
                                nombre_puesto.value = '';descripcion_puesto.value ='';
                                mensaje("success","Exitoso",data.msg);
                                tablepuesto.ajax.reload(function(){
                                    setTimeout(function(){ 
                                        fetchEdit('.btnEditarPuesto','puest','puestos','getPuesto','Actualizacion de puesto',
                                        ['nombre_puesto','descripcion'],'id_puesto','#modalPuesto',
                                        ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')
                                        fetchDelete('.btnEliminarPuesto','puest','puestos','delPuesto',
                                        'Eliminar puesto',"¿Desea eliminar este puesto?",'#modalPuesto',tablepuesto);
                                    }, 500);
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
                return validateInnput([nombre_puesto,descripcion_puesto],regex_string);
            }
        }else{
            return validateEmptyFields([nombre_puesto,descripcion_puesto,estado_puesto])
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
        fetchEdit('.btnEditarPuesto','puest','puestos','getPuesto','Actualizacion de puesto',
        ['nombre_puesto','descripcion'],'id_puesto','#modalPuesto',
        ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')
        fetchDelete('.btnEliminarPuesto','puest','puestos','delPuesto',
        'Eliminar puesto',"¿Desea eliminar este puesto?",'#modalPuesto',tablepuesto);
    }, 500);
},false);


fetchEdit('.btnEditarPuesto','puest','puestos','getPuesto','Actualizacion de puesto',
['nombre_puesto','descripcion'],'id_puesto','#modalPuesto',
ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')

fetchDelete('.btnEliminarPuesto','puest','puestos','delPuesto',
'Eliminar puesto',"¿Desea eliminar este puesto?",'#modalPuesto',tablepuesto);






