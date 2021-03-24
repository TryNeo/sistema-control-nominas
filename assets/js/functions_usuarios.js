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
        let camps = new Array();
        let campsRegex = new Array();

        let id_usuario = document.querySelector('#id_usuario').value;
        let nombreInput = document.querySelector('#nombre').value;
        let apellidoInput = document.querySelector('#apellido').value;
        let usuarioInput = document.querySelector('#usuario').value;
        let emailInput = document.querySelector('#email').value;
        let passwordInput = document.querySelector('#password').value;
        let imagenInput = document.querySelector('#foto').value;
        let id_rol = document.querySelector('#id_rol').value;
        let estadoInput = document.querySelector('#estadoInput').value;
        camps.push(nombreInput,apellidoInput,usuarioInput,estadoInput,id_rol);
        campsRegex.push(nombreInput,apellidoInput)
        if(validateCamps(camps)){
            if (isValidString(campsRegex)){
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+"usuarios/setUsuario";
                let formData = new FormData(formUsuario);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState==4 && request.status == 200){
                        let objData = JSON.parse(request.responseText); 
                        if (objData.status){
                            $('#modalUsuario').modal("hide");
                            let camps = new Array();
                            camps.push("nombre","apellido","usuario","email","password","foto")
                            camps.forEach(function(element,index){
                                document.querySelector('#'+element).value = '';
                            })
                            mensaje("success","Exitoso",objData.msg);
                            tableusuarios.ajax.reload(function() {
                                setTimeout(function(){ 
                                    baseAjaxEdit('.btnEditarUsuario','us','usuarios','getUsuario',
                                    'Actualizar el usuario',["nombre","apellido","usuario","email"],
                                    'id_usuario','#modalUsuario',ExistSelect = true,'id_rol',ImagePreview = true,'#ImagePreview',ExistSelect_two = false,'');
                                    baseAjaxDelete('.btnEliminarUsuario','us','usuarios','delUsuario','Eliminar usuario',
                                    "¿Desea eliminar este usuario?",'#modalUsuario',tableusuarios);
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

    setTimeout(() => {
        baseAjaxSelect('id_rol','getSelectRoles','roles','Seleciona el rol');
    }, 1000);
},false);

window.addEventListener('click',function(){
    setTimeout(function(){ 
        baseAjaxEdit('.btnEditarUsuario','us','usuarios','getUsuario',
        'Actualizar el usuario',["nombre","apellido","usuario","email"],
        'id_usuario','#modalUsuario',ExistSelect = true,'id_rol',ImagePreview = true,'#ImagePreview',ExistSelect_two = false,'');
        baseAjaxDelete('.btnEliminarUsuario','us','usuarios','delUsuario','Eliminar usuario',"¿Desea eliminar este usuario?",'#modalUsuario',tableusuarios);
    },500);
})


baseAjaxEdit('.btnEditarUsuario','us','usuarios','getUsuario',
    'Actualizar el usuario',["nombre","apellido","usuario","email"],
    'id_usuario','#modalUsuario',ExistSelect = true,'id_rol',ImagePreview = true,'#ImagePreview',ExistSelect_two = false,'');

    
baseAjaxDelete('.btnEliminarUsuario','us','usuarios','delUsuario',
'Eliminar usuario',"¿Desea eliminar este usuario?",'#modalUsuario',tableusuarios);



baseAjaxSelect('id_rol','getSelectRoles','roles','Seleciona el rol');


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


