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

        let id_usuario = document.querySelector('#id_usuario').value;
        let nombreInput = document.querySelector('#nombre').value;
        let apellidoInput = document.querySelector('#apellido').value;
        let usuarioInput = document.querySelector('#usuario').value;
        let emailInput = document.querySelector('#email').value;
        let passwordInput = document.querySelector('#password').value;
        let imagenInput = document.querySelector('#foto').value;
        let id_rol = document.querySelector('#id_rol').value;
        let estadoInput = document.querySelector('#estadoInput').value;
        camps.push(nombreInput,apellidoInput,usuarioInput,passwordInput,estadoInput,id_rol);
        if(validateCamps(camps)){
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
                                'Actualizar el usuario',["nombre","apellido","usuario","email","password"],
                                'id_usuario','#modalUsuario',ExistSelect = true,'id_rol',ImagePreview = true,'#ImagePreview');
                                baseAjaxDelete('.btnEliminarUsuario','us','usuarios','delUsuario','Eliminar usuario',"¿Desea eliminar este usuario?",'#modalUsuario',tableusuarios);
                            }, 500);
                        });
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
        }else{
            return validateCamps(camps);
        }

    });


},false);

window.addEventListener('click',function(){
    setTimeout(function(){ 
        baseAjaxEdit('.btnEditarUsuario','us','usuarios','getUsuario',
        'Actualizar el usuario',["nombre","apellido","usuario","email","password"],
        'id_usuario','#modalUsuario',ExistSelect = true,'id_rol',ImagePreview = true,'#ImagePreview');
        baseAjaxDelete('.btnEliminarUsuario','us','usuarios','delUsuario','Eliminar usuario',"¿Desea eliminar este usuario?",'#modalUsuario',tableusuarios);
    },500);
})


window.addEventListener('load',function(){
    fntRolesUsuario();
},false);

baseAjaxEdit('.btnEditarUsuario','us','usuarios','getUsuario',
    'Actualizar el usuario',["nombre","apellido","usuario","email","password"],
    'id_usuario','#modalUsuario',ExistSelect = true,'id_rol',ImagePreview = true,'#ImagePreview');

/*
function fntEditUsuario(){
    let btnEditUsuario = document.querySelectorAll('.btnEditarUsuario');
    btnEditUsuario.forEach(function(btnEditUsuario) {
        btnEditUsuario.addEventListener('click',function() {
            document.querySelector('.text-center').innerHTML = " Actualizar Registro";
            document.querySelector('#modalTitle').innerHTML = "Actualizar el usuario";
            document.querySelector('#btnDisabled').style.display = 'none';

            let id_usuario = this.getAttribute('us');
            let ajaxUrl = "http://localhost/sistema-control-nominas/usuarios/getUsuario/"+id_usuario;
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let camps = new Array();
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    camps.push("nombre","apellido","usuario","email","password")
                    if (objData.status){
                        document.querySelector('#id_usuario').value = objData.msg.id_usuario;
                        camps.forEach(function(element,index){
                            document.querySelector('#'+element).value = objData.msg[element];
                        })
                        
                        let a = document.querySelector("#id_rol").getElementsByTagName('option');
                        for (let item of a){
                            if (item.value ===  objData.msg.id_rol) {
                                item.setAttribute("selected","");
                                $('#id_rol').selectpicker('render');
                            }else{
                                item.removeAttribute("selected");
                                $('#id_rol').selectpicker('render');
                            }
                        }


                        const optionsSelect = document.querySelector("#estadoInput") .getElementsByTagName("option"); 
                        for (let item of optionsSelect ) {
                                if (item.value == objData.msg.estado) {
                                    item.setAttribute("selected","");
                                } else {
                                    item.removeAttribute("selected");
                                }
                        }
                        $('#modalUsuario').modal("hide");
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
            $('#modalUsuario').modal("show");

        })
    })
}
*/

baseAjaxDelete('.btnEliminarUsuario','us','usuarios','delUsuario','Eliminar usuario',"¿Desea eliminar este usuario?",'#modalUsuario',tableusuarios);

/*
function fntDelUsuario(){
    let btnDelUsuario = document.querySelectorAll('.btnEliminarUsuario');
    btnDelUsuario.forEach(function(btnDelUsuario){
        btnDelUsuario.addEventListener('click',function(){
            let id_usuario = this.getAttribute('us');
            Swal.fire({
                title: 'Eliminar usuario',
                text: "¿Desea eliminar este usuario?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText : 'No, cancelar',
              }).then((result) => {
                if (result.isConfirmed) {
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = "http://localhost/sistema-control-nominas/usuarios/delUsuario";
                    let strData = "id_usuario="+id_usuario;
                    request.open("POST",ajaxUrl,true);
                    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function(){
                        if(request.readyState==4 && request.status == 200){
                            let objData = JSON.parse(request.responseText); 
                            if (objData.status){
                                $('#modalUsuario').modal("hide");
                                mensaje("success","Exitoso",objData.msg);
                                tableusuarios.ajax.reload(function () {
                                    fntEditUsuario();
                                    fntDelUsuario();
                                });
                            }else{
                                mensaje("error","Error",objData.msg);
                            }
                        }
                    }
                    }
                });
                
        });
    });
}
*/

function fntRolesUsuario() {
    let ajaxUrl = base_url+"roles/getSelectRoles";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            document.querySelector("#id_rol").innerHTML = "<option  selected disabled='disabled'  value='0'>Seleciona el rol</option>"+request.responseText;
            document.querySelector("#id_rol").value = 1;
            $('#id_rol').val('0');
            $('#id_rol').selectpicker('render');
        }
    }

}

function abrir_modal_user(){
    var options = {
        "backdrop" : "static",
        "show":true
    }
    document.querySelector('#id_usuario').value="";
    let camps = new Array();
    camps.push("nombre","apellido","usuario","email","password")
    camps.forEach(function(element,index){
        document.querySelector('#'+element).value = '';
    })
    document.querySelector('#ImagePreview').innerHTML ='';
    document.querySelector('.text-center').innerHTML = " Guardar Registro";
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo usuario";
    document.querySelector('#btnDisabled').style.display = 'inline-block';

    $('#modalUsuario').modal(options);
}





