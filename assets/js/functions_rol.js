let tableroles;

document.addEventListener('DOMContentLoaded',function(){
    tableroles = $('.table').DataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
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
            {"data":"nombre"},
            {"data":"descripcion"},
            {"data":"estado"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });

    let formRol = document.querySelector('#formRol');   
    formRol.addEventListener('submit', function (e) {
        e.preventDefault();
        let rolInput = document.getElementById('rolInput').value;
        let descriInput = document.getElementById('descriInput').value;
        let estadoInput = document.getElementById('estadoInput').value;
        if(validate(rolInput,descriInput,estadoInput)){
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
                        mensaje("success","Exitoso",objData.msg);
                        tableroles.ajax.reload(function () {});
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
        }else{
            return validate(rolInput,descriInput,estadoInput);
        }
    });

});

function abrir_modal(){
    var options = {
        "backdrop" : "static",
        "show":true
    }
    document.querySelector('#id_rol').innerHTML="";
    document.querySelector('.text-center').innerHTML = " Guardar Registro";
    document.querySelector('#modalTitle').innerHTML = "Creacion de nuevo rol";
    document.querySelector('#btnDisabled').style.display = 'inline-block';
    $('#modalRol').modal(options);
}

function cerrar_modal(){
    $('#modalRol').modal("hide");
}



window.addEventListener('click',function(){
    setTimeout(() => { 
        fntEditRol();
    }, 500);
},false);


function fntEditRol(){
    let btnEditRol = document.querySelectorAll('.btnEditarRol');
        btnEditRol.forEach(function(btnEditRol){
            btnEditRol.addEventListener('click',function(){
                document.querySelector('#modalTitle').innerHTML = "Actualizacion de rol";
                document.querySelector('.text-center').innerHTML = " Actualizar registro";
                document.querySelector('#btnDisabled').style.display = 'none';
                $('#modalRol').modal("show");
            });
        });
}



function validate(rolInput,descriInput,estadoInput){
    if ((rolInput === "") || (descriInput === "") || (estadoInput === "")){
        return mensaje("error","Error","Todos los campos son obligatorios");
    }else{
        let rol = isValidString(rolInput);
        let descript = isValidString(descriInput);
        if ((rol === true && descript === true)){
            return true;
        }else{
            mensaje("error","Error","Los campos ingresados no son validos")
            return false;
        }
    }
 
}


function isValidString(str1) {
    const validRegEx = /^[^\\\/&]*$/
    if(typeof str1 === 'string' && str1.match(validRegEx) && str1.length > 5) {
        return true;
    } else {
        return false;
    }
  }

  
function mensaje(icon,title,text){
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
      })
}