document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector("#formLogin")) {
        let formLogin = document.querySelector("#formLogin");
        formLogin.addEventListener('submit', (e) =>  {
            e.preventDefault();
            let username = document.querySelector('#username').value;
            let password = document.querySelector('#password').value;
            let validate_data = [username,password];
            if (validateEmptyFields(validate_data)) {
                if (validateInnput(validate_data,regex_username_password)){
                    (async () => {
                        try {
                            const data = new FormData(formLogin);
                            let options = { method: "POST", body:data}
                            let response = await fetch(base_url+"login/loginUser",options);
                            if (response.ok) {
                                let data = await response.json();
                                if (data.status){
                                    mensaje("success","Exitoso",data.msg);
                                    setTimeout(function(){window.location = base_url+"dashboard";},1500);
                                }else{
                                    mensaje("error","Error",data.msg);
                                    document.querySelector('#password').value = '';
                                }
                            } else {
                                mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                            }
                        } catch (err) {
                            mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                        }
                    })();
                }else{
                    return validateInnput(validate_data);
                }
            }else{
                return validateEmptyFields(validate_data);
            }
        });
    }
},false)