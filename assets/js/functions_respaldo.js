let tablerespaldo;
document.addEventListener('DOMContentLoaded',function(){
    tablerespaldo = $('.tableRespaldo').DataTable({
        "pageLength": 4,
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
            "url" : base_url+"respaldo/getBackups",
            "dataSrc":""
        },
        "columns":[
            {"data":"id"},
            {"data":"nombre"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });
});


window.addEventListener('load',function(){
    setTimeout(function(){ 
        fntDeleteBackup();
        fntSetBackups();
        fntBackups();
    }, 500);
},false);



function fntSetBackups(){
    let restorebd = document.querySelectorAll(".btnRestore");
    restorebd.forEach(function(restorebd){
        restorebd.addEventListener('click', function (e) {
            e.preventDefault();
            let rbd = this.getAttribute('rbd');
            Swal.fire({
                title:  "Restauracion de base la datos",
                text: '¿Desea realizar la restauracion de la base de datos?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, restaurar',
                cancelButtonText : 'No, restaurar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if (rbd === ""){
                        mensaje("error","Error","Opps! hubo un problema esta base de datos no existe");
                    }else{
                        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                        let ajaxUrl = base_url+"respaldo/setBackups?route="+rbd;
                        request.open("GET",ajaxUrl,true);
                        request.send();
                        request.onreadystatechange = function(){
                            if(request.readyState==4 && request.status == 200){
                                let objData = JSON.parse(request.responseText);
                                if (objData.status){
                                    mensaje("success","Exitoso",objData.msg);
                                    tablerespaldo.ajax.reload();
                                }else{
                                    mensaje("error","Error",objData.msg);
                                }
                            }
                        }
                    }    
                }
            });
        });
    })    
}

function fntDeleteBackup(){
    let deletebd = document.querySelectorAll(".btnRestoreEliminar");
    deletebd.forEach(function(deletebd){
        deletebd.addEventListener('click', function (e) {
            e.preventDefault();
            let rbd = this.getAttribute('rbd');
            Swal.fire({
                title:  "Eliminar copia de base de datos",
                text: '¿Desea eliminar esta copia de base de datos?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText : 'No, cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    if (rbd === ""){
                        mensaje("error","Error","Opps! hubo un problema esta base de datos no existe");
                    }else{
                        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                        let ajaxUrl = base_url+"respaldo/delBackups?route="+rbd;
                        request.open("GET",ajaxUrl,true);
                        request.send();
                        request.onreadystatechange = function(){
                            if(request.readyState==4 && request.status == 200){
                                let objData = JSON.parse(request.responseText);
                                if (objData.status){
                                    mensaje("success","Exitoso",objData.msg);
                                    tablerespaldo.ajax.reload(function() {
                                        fntSetBackups();
                                        fntDeleteBackup();
                                    });
                                }else{
                                    mensaje("error","Error",objData.msg);
                                }
                            }
                        }
                    }
                }
            });
            
        });
    })     
}


function fntBackups(){
    if (document.querySelector("#backupbd")) {
        let backupbd = document.querySelector("#backupbd");
        backupbd.addEventListener('click', function (e) {
            e.preventDefault();
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+"respaldo/backup";
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if (objData.status){
                        mensaje("success","Exitoso",objData.msg);
                        tablerespaldo.ajax.reload(function() {
                            fntSetBackups();
                            fntDeleteBackup();
                        });
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
        });
    }
}




