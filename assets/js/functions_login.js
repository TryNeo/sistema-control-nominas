document.addEventListener('DOMContentLoaded',function () {
    if (document.querySelector("#formLogin")) {
        let formLogin = document.querySelector("#formLogin");
        formLogin.addEventListener('submit', function (e) {
            e.preventDefault();
            let camps = new Array();
            let username = document.querySelector('#username').value;
            let password = document.querySelector('#password').value;
            camps.push(username,password);
            if (validateCamps(camps)) {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+"login/loginUser";
                let formData = new FormData(formLogin);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState==4 && request.status == 200){
                        let objData = JSON.parse(request.responseText); 
                        if (objData.status){
                            mensaje("success","Exitoso",objData.msg);
                            setTimeout(function(){
                                window.location = base_url+"dashboard";
                            },1500);
                        }else{
                            mensaje("error","Error",objData.msg);
                            document.querySelector('#password').value = '';
                        }
                    }
                }
            }else{
                return validateCamps(camps);
            }
        });
    }
},false)


