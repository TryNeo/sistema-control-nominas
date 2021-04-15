let tableroles;

document.addEventListener('DOMContentLoaded',function(){
    tableroles = $('.tableRol').DataTable({
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
            "url" : base_url+"roles/getRoles",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_rol"},
            {"data":"nombre_rol"},
            {"data":"descripcion"},
            {"data":"estado"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });

    let formRol = document.querySelector('#formRol');
    formRol.addEventListener('submit', (e) => {
        e.preventDefault();        
        let id_rol = document.querySelector('#id_rol').value;
        let nombre_rol = document.querySelector('#nombre_rol').value;
        let descripcion_rol = document.querySelector('#descripcion').value;
        let estado_rol = document.querySelector('#estadoInput').value;
        let validate_data = [nombre_rol,descripcion_rol,estado_rol];
        let validate_data_regex = [nombre_rol,descripcion_rol];
        if(validateEmptyFields(validate_data)){
            if (validateInnput(validate_data_regex,regex_string) && validateInnput([estado_rol],regex_numbers)){
                (async () => {
                    try {
                        const data = new FormData(formRol);
                        let options = { method: "POST", body:data}
                        let response = await fetch(base_url+"roles/setRol",options);
                        if (response.ok) {
                            let data = await response.json();
                            if (data.status){
                                $('#modalRol').modal("hide");
                                id_rol.value = '';nombre_rol.value='';descripcion_rol.value='';
                                mensaje("success","Exitoso",data.msg);
                                tableroles.ajax.reload(function() {
                                    setTimeout(function(){ 
                                        fetchPermRol();
                                        fetchEdit('.btnEditarRol','rl','roles','getRol','Actualizacion de rol',
                                        ['nombre_rol','descripcion'],'id_rol','#modalRol',
                                        ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'')
                                        fetchDelete('.btnEliminarRol','rl','roles','delRol','Eliminar rol',
                                        "¿Desea eliminar este rol?",'#modalRol',tableroles);
                                    }, 500);
                                });
                            }else{
                                mensaje("error","Error",data.msg);
                            }
                        } else {
                            mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                        }
                    } catch (err) {
                        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                    }
                })();
            }else{
                return validateInnput(validate_data_regex,regex_string),
                validateInnput([estado_rol],regex_numbers)
                ;
            }
        }else{
            return validateEmptyFields(validate_data)
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
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo rol";
    document.querySelector('#btnDisabled').style.display = 'inline-block';
    let idRol = document.querySelector('#id_rol').value = '';
    let rolInput = document.querySelector('#nombre_rol').value = '';
    let descriInput = document.querySelector('#descripcion').value = '';
    let estadoInput = document.querySelector('#estadoInput').value;
    $('#modalRol').modal(options);
}

window.addEventListener('click',function(){
    setTimeout(function(){ 
            fetchPermRol();
            fetchEdit('.btnEditarRol','rl','roles','getRol','Actualizacion de rol',
            ['nombre_rol','descripcion'],'id_rol','#modalRol',ExistSelect = false,'',ImagePreview = false,'',ExistSelect_two = false,'');
            fetchDelete('.btnEliminarRol','rl','roles','delRol',
            'Eliminar rol',"¿Desea eliminar este rol?",'#modalRol',tableroles);
    }, 500);
},false);


fetchEdit('.btnEditarRol','rl','roles','getRol','Actualizacion de rol',
['nombre_rol','descripcion'],'id_rol','#modalRol',ExistSelect = false,
'',ImagePreview = false,'',ExistSelect_two = false,'')


fetchDelete('.btnEliminarRol','rl','roles','delRol','Eliminar rol',"¿Desea eliminar este rol?",'#modalRol',tableroles);


async function fetchPermRol(){
    let btnPermRol = document.querySelectorAll('.btnPermiso');
    btnPermRol.forEach(function(btnPermRol){
        btnPermRol.addEventListener('click',function(){
            (async () => {
                try {
                    let id_rol = this.getAttribute('rl');
                    let options = { method: "GET"}
                    let response = await fetch(base_url+"Permisos/getPermisosRol/"+id_rol,options);
                    if (response.ok) {
                        let data = await response.text();
                        document.querySelector("#contentAjax").innerHTML = data;
                        document.querySelector('#formPermisos').addEventListener('submit',fetchSavePermisos,false);
                        $('.modalPermisos').modal("show");
                    }else {
                        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                    }
                } catch (err) {
                    mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                }
            })();
        });
    });
}

async function fetchSavePermisos(event){
    event.preventDefault();
    try {
        let formElement = document.querySelector("#formPermisos");
        const data = new FormData(formElement);
        let options = { method: "POST", body:data}
        let response = await fetch(base_url+"Permisos/setPermisos",options);
        if (response.ok) {
            let data = await response.json();
            if (data.status){
                mensaje("success","Exitoso",data.msg);
                $('.modalPermisos').modal("hide");
            }else{
                mensaje("error","Error",data.msg);
            }
        } else {
            mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
        }

    } catch (err) {
        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
    }
    
}


