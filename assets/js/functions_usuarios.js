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
            "url" : "http://localhost/sistema-control-nominas/usuarios/getUsuarios",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_usuario"},
            {"data":"nombre"},
            {"data":"apellido"},
            {"data":"usuario"},
            {"data":"email"},
            {"data":"id_rol"},
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
        let id_rol = document.querySelector('#id_rol').value;
        let estadoInput = document.querySelector('#estadoInput').value;
        camps.push(nombreInput,apellidoInput,usuarioInput,passwordInput,estadoInput,id_rol);
        if(validateCamps(camps)){
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = "http://localhost/sistema-control-nominas/usuarios/setUsuario";
            let formData = new FormData(formUsuario);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status == 200){
                    let objData = JSON.parse(request.responseText); 
                    if (objData.status){
                        $('#modalUsuario').modal("hide");
                        let id_usuario = document.querySelector('#id_usuario').value = '';
                        let nombreInput = document.querySelector('#nombre').value = '';
                        let apellidoInput = document.querySelector('#apellido').value = '';
                        let usuarioInput = document.querySelector('#usuario').value = '';
                        let emailInput = document.querySelector('#email').value = '';
                        let passwordInput = document.querySelector('#password').value = '';
                        let id_rol = document.querySelector('#id_rol').value = '0';
                        mensaje("success","Exitoso",objData.msg);
                        tableusuarios.ajax.reload(null, false);

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


window.addEventListener('load',function(){
    tableusuarios.ajax.reload(null, false);

    fntRolesUsuario();
},false);






function fntRolesUsuario() {
    let ajaxUrl = "http://localhost/sistema-control-nominas/roles/getSelectRoles";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            document.querySelector("#id_rol").innerHTML = "<option  selected disabled='disabled'  value='0'>Seleciona el estado</option>"+request.responseText;
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
    document.querySelector('.text-center').innerHTML = " Guardar Registro";
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo usuario";
    document.querySelector('#btnDisabled').style.display = 'inline-block';

    $('#modalUsuario').modal(options);
}