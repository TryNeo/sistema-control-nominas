document.addEventListener('DOMContentLoaded',function () {
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
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
        });
    }
},false)


