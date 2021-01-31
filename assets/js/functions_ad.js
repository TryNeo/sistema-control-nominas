function abrir_modal(nameModal){
    var options = {
        "backdrop" : "static",
        "show":true
    }
    $('#'+nameModal).modal(options);
}

function cerrar_modal(nameModal){
    $('#'+nameModal).modal("hide");
}

