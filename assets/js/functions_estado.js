let tableestadonomina;

document.addEventListener('DOMContentLoaded',function(){
    tableestadonomina = $('.tableEstado').DataTable({
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
            "url" :base_url+"nominas/getEstadoNominas",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_nomina"},
            {"data":"nombre_nomina"},
            {"data":"periodo_inicio"},
            {"data":"periodo_fin"},
            {"data":"estado_nomina"},
            {"data":"total"},
            {"data":"opciones"}
        ],
        "order":[[0,"desc"]]
    });
});


window.addEventListener('click',function(){
    setTimeout(function(){ 
        fetchAceptarNomina();
        fetchRechazarNomina();
    }, 500);
},false);


async function fetchAceptarNomina(){
    let btnAceptarNomina = document.querySelectorAll('.btnAceptarNomina');
    btnAceptarNomina.forEach(function(btnAceptarNomina){
        btnAceptarNomina.addEventListener('click',function(){
            let id_nomina = this.getAttribute('nom');
            let estado = this.getAttribute('acept');
            Swal.fire({
                    title: 'Validar nomina',
                    text: '¿Desea validar esta nomina?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Aceptar',
                    cancelButtonText : 'No, cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    (async () => {
                        try {
                            let data = new FormData();data.append("id_nomina",id_nomina);data.append("estado",estado);
                            let options = { method: "POST", body :data}
                            let response = await fetch(base_url+"nominas/setEstadoNominas",options);
                            if (response.ok) {
                                let data = await response.json();
                                if(data.status){
                                    mensaje("success","Exitoso",data.msg);
                                    tableestadonomina.ajax.reload();
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
                }
            });
        })
    })
}


async function fetchRechazarNomina(){
    let btnRechazarNomina = document.querySelectorAll('.btnRechazarNomina');
    btnRechazarNomina.forEach(function(btnRechazarNomina){
        btnRechazarNomina.addEventListener('click',function(){
            let id_nomina = this.getAttribute('nom');
            let estado = this.getAttribute('rech');
            Swal.fire({
                    title: 'Rechazar nomina',
                    text: '¿Desea rechazar esta nomina?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Aceptar',
                    cancelButtonText : 'No, cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    (async () => {
                        try {
                            let data = new FormData();data.append("id_nomina",id_nomina);data.append("estado",estado);
                            let options = { method: "POST", body :data}
                            let response = await fetch(base_url+"nominas/setEstadoNominas",options);
                            if (response.ok) {
                                let data = await response.json();
                                if(data.status){
                                    mensaje("success","Exitoso",data.msg);
                                    tableestadonomina.ajax.reload();
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
                }
            });
        })
    })
}