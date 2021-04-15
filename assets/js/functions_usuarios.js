let tableusuarios;


document.addEventListener('DOMContentLoaded',function(){
    tableusuarios = $('.tableUsuarios').DataTable({
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
            "url" : base_url+"usuarios/getUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_usuario"},
            {"data":"nombre"},
            {"data":"apellido"},
            {"data":"usuario"},
            {"data":"email"},
            {"data":"nombre_rol"},
            {"data":"foto"},
            {"data":"estado"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });

    let formUsuario = document.querySelector('#formUsuario');
    formUsuario.addEventListener('submit', function (e) {
        e.preventDefault();        
        let id_usuario = document.querySelector('#id_usuario').value;
        let nombre_usuario = document.querySelector('#nombre').value;
        let apellido_usuario = document.querySelector('#apellido').value;
        let usuario_name = document.querySelector('#usuario').value;
        let email_usuario = document.querySelector('#email').value;
        let password_usuario = document.querySelector('#password').value;
        let imagen_usuario = document.querySelector('#foto').value;
        let id_rol_usuario = document.querySelector('#id_rol').value;
        let estado_usuario = document.querySelector('#estadoInput').value;
        let validate_data = [nombre_usuario,apellido_usuario,usuario_name,email_usuario,id_rol_usuario,estado_usuario];
        let validate_data_regex = [nombre_usuario,apellido_usuario]
        let validate_data_numbers = [id_rol_usuario,estado_usuario]
        if(validateEmptyFields(validate_data)){
            if (validateInnput(validate_data_regex,regex_string) &&
                    validateInnput(validate_data_numbers,regex_numbers) && validateInnput([usuario_name],regex_username_password)
                    && validateInnput([email_usuario],regex_email)){
                    (async () => {
                        try {
                            const data = new FormData(formUsuario);
                            let options = { method: "POST", body:data}
                            let response = await fetch(base_url+"usuarios/setUsuario",options);
                            if (response.ok) {
                                let data = await response.json();
                                if(data.status){
                                    $('#modalUsuario').modal("hide");
                                    let camps = new Array();
                                    camps.push("nombre","apellido","usuario","email","password","foto")
                                    camps.forEach(function(element,index){
                                        document.querySelector('#'+element).value = '';
                                    })
                                    mensaje("success","Exitoso",data.msg);
                                    tableusuarios.ajax.reload(function() {
                                        setTimeout(function(){ 
                                            fetchEdit('.btnEditarUsuario','us','usuarios','getUsuario',
                                            'Actualizar el usuario',["nombre","apellido","usuario","email"],
                                            'id_usuario','#modalUsuario',ExistSelect = true,'id_rol',ImagePreview = true,'#ImagePreview',ExistSelect_two = false,'');
                                            fetchDelete('.btnEliminarUsuario','us','usuarios','delUsuario','Eliminar usuario',
                                            "¿Desea eliminar este usuario?",'#modalUsuario',tableusuarios);
                                        }, 500);
                                    });
                                }else{
                                    mensaje("error","Error",data.msg);
                                }
                            }else{
                                mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                            }
                    } catch (err) {
                        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                    }
                })();
            }else{
                return validateInnput(validate_data_regex,regex_string),
                        validateInnput(validate_data_numbers,regex_numbers),
                        validateInnput([usuario_name,password_usuario],regex_username_password),
                        validateInnput([email_usuario],regex_email);
            }
        }else{
            return validateEmptyFields(validate_data);
        }

    });

    setTimeout(() => {
        fetchSelect('id_rol','getSelectRoles','roles','Seleciona el rol');
    }, 1000);
},false);

window.addEventListener('click',function(){
    setTimeout(function(){ 
        fetchEdit('.btnEditarUsuario','us','usuarios','getUsuario',
        'Actualizar el usuario',["nombre","apellido","usuario","email"],
        'id_usuario','#modalUsuario',ExistSelect = true,'id_rol',ImagePreview = true,'#ImagePreview',ExistSelect_two = false,'');
        fetchDelete('.btnEliminarUsuario','us','usuarios','delUsuario','Eliminar usuario',"¿Desea eliminar este usuario?",'#modalUsuario',tableusuarios);
    },500);
})


fetchEdit('.btnEditarUsuario','us','usuarios','getUsuario',
    'Actualizar el usuario',["nombre","apellido","usuario","email"],
    'id_usuario','#modalUsuario',ExistSelect = true,'id_rol',ImagePreview = true,'#ImagePreview',ExistSelect_two = false,'');

    
fetchDelete('.btnEliminarUsuario','us','usuarios','delUsuario',
'Eliminar usuario',"¿Desea eliminar este usuario?",'#modalUsuario',tableusuarios);



fetchSelect('id_rol','getSelectRoles','roles','Seleciona el rol');


function abrir_modal_user(){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    document.querySelector('#id_usuario').value="";
    let camps = new Array();
    camps.push("nombre","apellido","usuario","email","password","foto","estadoInput")
    camps.forEach(function(element,index){
        document.querySelector('#'+element).value = '';
    })
    document.querySelector('#ImagePreview').innerHTML ='';
    document.querySelector('.text-center').innerHTML = " Guardar Registro";
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo usuario";
    document.querySelector('#btnDisabled').style.display = 'inline-block';
    $('#id_rol').val('0');
    $('#id_rol').selectpicker('render');
    $('#modalUsuario').modal(options);
}


function abrir_modal_imagen(){
    $('#imagenModal').modal("show");
}


