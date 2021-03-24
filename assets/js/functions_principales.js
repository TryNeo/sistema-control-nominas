const base_url = "http://localhost/sistema-control-nominas/";
const base_url_image = "http://localhost/sistema-control-nominas/assets/images/";


document.addEventListener('DOMContentLoaded',function(){

    fntRestaurarPassword();

})





function validateCamps(listCamps){
  let newlistCamps = new Array();
  let errorCamps = new Array();
  
    listCamps.forEach(function(elements, index) {
        if(listCamps[index] === ""){
            errorCamps.push(listCamps[index]);
        }else{
            newlistCamps.push(listCamps[index]);
        }
    })
    
    if (errorCamps.length > 0){
        mensaje("error","Error","Todos los campos son obligatorios");
        return false;
    }else{
        return true;
    }
}

function cerrar_modal(nameSelector){
    $(nameSelector).modal("hide");
}


function isValidString(listCamps) {
    const validRegEx = "^[a-zA-Z 0-9]+$";
    let errorCamps = new Array();
    let validCamps = new Array();

    listCamps.forEach(function(elements, index){
        if(typeof listCamps[index] === "number"){
            validCamps.push(listCamps[index]);
        }
    });

    listCamps.forEach(function(elements, index){
        if(String(listCamps[index]).match(validRegEx)) {
            validCamps.push(listCamps[index]);
        } else {
            errorCamps.push(listCamps[index]);
        }
    });

    if (errorCamps.length > 0){
        mensaje("error","Error","Los campos "+errorCamps+" estan mal escritos,introduzca un texto  valida");
        return false;
    }else{
        return true;
    }

};

function validateCedula(cedula){
    const validRegEx = /[0-9]{0,10}/;
    if (cedula.match(validRegEx) === null){
        return false;
    }else{
        let validado = [...cedula].map( x => x == 0 ? 0 : (parseInt(x) || x));
        let ultimo_numero = parseInt(validado.splice(9,1));
        let cedula_impar = validado.filter((x,c)=> {if (c%2==1){return validado[c]}});
        let cedula_pares = validado.filter((x,c)=> {if (c%2==0){return validado[c]}}).map((x)=>x+=x);

        let totales = cedula_pares.filter(
            (x,c) => {if (cedula_pares[c] <= 9){return cedula_pares[c]
            }}).concat(cedula_pares.filter((x,c) => {if (cedula_pares[c] >= 9){ 
                return cedula_pares[c]
                }
            }
            ).map(x => x-9))

        let total_a = totales.reduce((acum,total)=> acum+total)+cedula_impar.reduce((acum,total)=> acum+total);
    
        let total = (parseInt(String(total_a).charAt(0))+1)*10
        if (total == 10){
            total = 0
        }

        if((total - (total_a)) == ultimo_numero  ){
            return true
        }else{
            return false
        }
    
        }
}

function mensaje(icon,title,text){
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
    })
}


function baseAjaxEdit(nameSelector,nameId,urlName,nameMethod,modalName,listCamps,
    nameSelectorId,nameSelectorModal,ExistSelect = false,selectId,ImagePreview = false, imageId,ExistSelect_two = false,selectId_two){
let btnBaseEdit = document.querySelectorAll(nameSelector);
    btnBaseEdit.forEach(function(btnBaseEdit){
        btnBaseEdit.addEventListener('click',function(){
            document.querySelector('#modalTitle').innerHTML = modalName;
            document.querySelector('.text-center').innerHTML = " Actualizar registro";
            document.querySelector('#btnDisabled').style.display = 'none';
            let id = this.getAttribute(nameId);
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxEdUser = base_url+urlName+"/"+nameMethod+"/"+id;
            request.open("GET",ajaxEdUser,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState==4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if (objData.status){
                        document.querySelector('#'+nameSelectorId).value = objData.msg[nameSelectorId];
                        listCamps.forEach(function(element,index){
                        document.querySelector('#'+element).value = objData.msg[element];
                    })
                        if (ImagePreview){
                            document.querySelector(imageId).innerHTML ="<img src='"+base_url_image+objData.msg['foto']+"'  class='img-100 img-fluid' ></div>";
                        }
                        
                        if(ExistSelect){
                            let a = document.querySelector("#"+selectId).getElementsByTagName('option');
                            for (let item of a){
                                if (item.value === objData.msg['id_rol']) {
                                    item.setAttribute("selected","");
                                }else{
                                    item.removeAttribute("selected");
                                }
                            }
                        }

                        if(ExistSelect_two){
                            let b = document.querySelector("#"+selectId_two).getElementsByTagName('option');
                            for (let item of b){
                                if (item.value === objData.msg['id_rol']) {
                                    item.setAttribute("selected","");
                                }else{
                                    item.removeAttribute("selected");
                                }
                            }
                        }

                        const optionsSelect = document.querySelector("#estadoInput") .getElementsByTagName("option"); 
                        for (let item of optionsSelect ) {
                            if (item.value == objData.msg.estado) {
                                item.setAttribute("selected","");
                            } else {
                                item.removeAttribute("selected");
                            }
                        }
                        $(nameSelectorModal).modal("hide");
                    }else{
                        mensaje("error","Error",objData.msg);
                    }
                }
            }
            $(nameSelectorModal).modal("show");
        });
    });
}


function baseAjaxDelete(nameSelector,nameId,urlName,nameMethod,title,text,modalName,tableupdate){
  var btnBaseDelete = document.querySelectorAll(nameSelector);
  btnBaseDelete.forEach(function(btnBaseDelete){
    btnBaseDelete.addEventListener('click',function(){
        var id = this.getAttribute(nameId);
        Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText : 'No, cancelar',
         }).then((result) => {
           if (result.isConfirmed) {
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+urlName+"/"+nameMethod;
                    let strData = "id="+id;
                    request.open("POST",ajaxUrl,true);
                    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function(){
                        if(request.readyState==4 && request.status == 200){
                            let objData = JSON.parse(request.responseText); 
                            if (objData.status){
                                $(modalName).modal("hide");
                                mensaje("success","Exitoso",objData.msg);
                                tableupdate.ajax.reload();
                            }else{
                                mensaje("error","Error",objData.msg);
                            }
                        }
                    }
                    }
                });
          
        })
      })
}


function baseAjaxSelect(nameSelector,nameMethod,urlName,nameMensaje){
    let ajaxUrl = base_url+urlName+"/"+nameMethod;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState==4 && request.status == 200){
            document.querySelector("#"+nameSelector).innerHTML = "<option  selected disabled='disabled'  value='0'>"+nameMensaje+"</option>"+request.responseText;
        }
    }
};



'use strict';

;( function ( document, window, index )
{
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
	});
}( document, window, 0 ));



let actualizarHora = function(){
	let fecha = new Date(),
		horas = fecha.getHours(),
		ampm,
		minutos = fecha.getMinutes(),
		segundos = fecha.getSeconds()

    if (horas >= 12) {
        horas = horas - 12;
        ampm = 'PM';
    } else {
        ampm = 'AM';
    }
    if (minutos < 10){ minutos = "0" + minutos; }
	if (segundos < 10){ segundos = "0" + segundos; }
    if(document.querySelector('.reloj') != null){
        document.querySelector('.reloj').innerHTML =horas+":"+minutos+":"+segundos+"<div class='ampm'>&nbsp;"+ampm+"</div>";
    }
};

actualizarHora();
let intervalo = setInterval(actualizarHora, 1000);



function abrir_modal_restaurar(){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    $('#modalRestaurar').appendTo("body").modal(options);
}


function mostrarPassword(){
    var cambio = document.getElementById("password");
    if(cambio.type == "password"){
        cambio.type = "text";
        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
        cambio.type = "password";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
} 



function fntRestaurarPassword(){
    let formRestaurar = document.querySelector('#formRestaurar');
    if(formRestaurar !=null){
        formRestaurar.addEventListener('submit', function (e){
            e.preventDefault();
            let camps = new Array();
            let idUsuario =  document.querySelector('#id_usuario_ses').value;
            let passwordInput = document.querySelector('#password_new').value;
            let passwordRepInput = document.querySelector('#rep_password').value;
            camps.push(passwordInput,passwordRepInput);
            if(validateCamps(camps)){
                if (passwordInput === passwordRepInput){
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+"usuarios/resUsuario";
                    let formData = new FormData(formRestaurar);
                    request.open("POST",ajaxUrl,true);
                    request.send(formData);
                    request.onreadystatechange = function(){
                        if(request.readyState==4 && request.status == 200){
                            let objData = JSON.parse(request.responseText); 
                            if (objData.status){
                                mensaje("success","Exitoso",objData.msg);
                                $('#modalRestaurar').modal("hide");
                                let passwordInput = document.querySelector('#password_new').value = '';
                                let passwordRepInput = document.querySelector('#rep_password').value = '';
                                setTimeout(function(){window.location.replace(base_url+"logout")},1500);
                            }else{
                                mensaje("error","Error",objData.msg);
                            }
                        }
                    }
                }else{
                    return mensaje("error","Error","Las contraseñas no coinciden")
                }
            }else{
                return validateCamps(camps);
            }
        });        
    }
}

