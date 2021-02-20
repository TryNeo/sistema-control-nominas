document.addEventListener('DOMContentLoaded',function () {
    let formRestore = document.querySelector('#formRestore');
    formRestore.addEventListener('submit', function (e) {
        e.preventDefault();
        let route = document.querySelector('#restorebd').value;
        if(route == 0){
            mensaje("error","Error","Elija una base de datos a restaurar")
        }else{
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+"respaldo/setBackups";
            let formData = new FormData(formRestore);
            request.open("POST",ajaxUrl,true);
            request.send(formData);            
        }
    });
    fntBackups();
},false)

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
                        fntGetBackups();
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
        });
    }
}

fntGetBackups();

function fntGetBackups(){
    let ajaxUrl = base_url+"respaldo/getBackups"
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            document.querySelector('#restorebd').innerHTML = "<option  selected disabled='disabled'  value='0'>Seleciona la base de datos</option>"+request.responseText;
        }
    }
}

