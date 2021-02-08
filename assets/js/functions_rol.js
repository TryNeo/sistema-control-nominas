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
            "url" : "http://localhost/sistema-control-nominas/roles/getRoles",
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
    formRol.addEventListener('submit', function (e) {
        e.preventDefault();        
        let camps = new Array();
        let idRol = document.querySelector('#id_rol').value;
        let rolInput = document.querySelector('#nombre_rol').value;
        let descriInput = document.querySelector('#descripcion').value;
        let estadoInput = document.querySelector('#estadoInput').value;
        camps.push(rolInput,descriInput,estadoInput);
        if(validateCamps(camps)){
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = "http://localhost/sistema-control-nominas/roles/setRol";
            let formData = new FormData(formRol);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status == 200){
                    let objData = JSON.parse(request.responseText); 
                    if (objData.status){
                        $('#modalRol').modal("hide");
                        let idRol = document.querySelector('#id_rol').value = '';
                        let rolInput = document.querySelector('#nombre_rol').value = '';
                        let descriInput = document.querySelector('#descripcion').value = '';
                        mensaje("success","Exitoso",objData.msg);
                        tableroles.ajax.reload(function() {
                            setTimeout(function(){ 
                                fntPermRol();
                                fntEditRol();
                                fntDelRol();
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


});

function abrir_modal(){
    var options = {
        "backdrop" : "static",
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
            fntPermRol();
            fntEditRol();
            fntDelRol();
     }, 500);
},false);


function fntEditRol(){
    let btnEditRol = document.querySelectorAll('.btnEditarRol');
        btnEditRol.forEach(function(btnEditRol){
            btnEditRol.addEventListener('click',function(){
                document.querySelector('#modalTitle').innerHTML = "Actualizacion de rol";
                document.querySelector('.text-center').innerHTML = " Actualizar registro";
                document.querySelector('#btnDisabled').style.display = 'none';

                    
                let id_rol = this.getAttribute('rl');
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxEdUser = "http://localhost/sistema-control-nominas/roles/getRol/"+id_rol;
                let camps = new Array();
                request.open("GET",ajaxEdUser,true);
                request.send();
                request.onreadystatechange = function(){
                    if(request.readyState==4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);
                        camps.push("nombre_rol",'descripcion')
                        if (objData.status){
                            document.querySelector('#id_rol').value = objData.msg.id_rol;
                            camps.forEach(function(element,index){
                                document.querySelector('#'+element).value = objData.msg[element];
                            })
                           const optionsSelect = document.querySelector("#estadoInput") .getElementsByTagName("option"); 
                            for (let item of optionsSelect ) {
                                if (item.value == objData.msg.estado) {
                                    console.log(item.value);
                                    item.setAttribute("selected","");
                                } else {
                                    item.removeAttribute("selected");
                                }
                            }
                            $('#modalRol').modal("hide");
                        }else{
                            mensaje("error","Error",objData.msg);
                        }
                    }
                }
                $('#modalRol').modal("show");
            });
        });
}

function fntDelRol(){
    let btnDelRol = document.querySelectorAll('.btnEliminarRol');
    btnDelRol.forEach(function(btnDelRol){
        btnDelRol.addEventListener('click',function(){
            let id_rol = this.getAttribute('rl');
            Swal.fire({
                title: 'Eliminar rol',
                text: "¿Desea eliminar este rol?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText : 'No, cancelar',
              }).then((result) => {
                if (result.isConfirmed) {
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = "http://localhost/sistema-control-nominas/roles/delRol";
                    let strData = "id_rol="+id_rol;
                    request.open("POST",ajaxUrl,true);
                    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function(){
                        if(request.readyState==4 && request.status == 200){
                            let objData = JSON.parse(request.responseText); 
                            if (objData.status){
                                $('#modalRol').modal("hide");
                                mensaje("success","Exitoso",objData.msg);
                                tableroles.ajax.reload(function () {
                                    fntPermRol();
                                    fntEditRol();
                                    fntDelRol();
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


function fntPermRol(){
    let btnPermRol = document.querySelectorAll('.btnPermiso');
    btnPermRol.forEach(function(btnPermRol){
        btnPermRol.addEventListener('click',function(){
            let id_rol = this.getAttribute('rl');
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = "http://localhost/sistema-control-nominas/Permisos/getPermisosRol/"+id_rol;
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status == 200){
                    document.querySelector("#contentAjax").innerHTML = request.responseText;
                    $('.modalPermisos').modal("show");
                    document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);
                }
            }
        });

    });
}

function fntSavePermisos(event){
    event.preventDefault();
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = "http://localhost/sistema-control-nominas/Permisos/setPermisos";
    let formElement = document.querySelector("#formPermisos");
    let formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            let objData = JSON.parse(request.responseText); 
            if(objData.status){
                $('.modalPermisos').modal("hide");
                mensaje("success","Exitoso",objData.msg);
            }else{
                mensaje("error","Error",objData.msg);
            }
        }
    }
}


