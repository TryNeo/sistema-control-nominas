const base_url = "http://localhost/sistema-control-nominas/";
const base_url_image = "http://localhost/sistema-control-nominas/assets/images/";


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
    let validation = cedula.match(validRegEx);
    if (validation === null){
        mensaje("error","Error","La cedula es incorrecta");
        return false;
    }else{
        let validate = Object.assign([],validation[0])
        let ultimo_digito = validate[ validate.length - 1 ];
        let primeros_digitos = [validate[0],validate[1],validate[2],validate[3],validate[4],
        validate[5],validate[6],validate[7],validate[8]];
        primeros_digitos = primeros_digitos.map( x => x == 0 ? 0 : (parseInt(x) || x));
        let array_1 = new Array()
        let array_2 = new Array()
        let array_3 = new Array()
        let array_4 = new Array()
        let array_5 = new Array()
        let array_6 = new Array()
        let digito  = new Array()

        for (i = 0; i < primeros_digitos.length; i++) {
            if(i%2 == 1){
                array_1.push(primeros_digitos[i])
            }
        }
    
        
        for (i = 0; i < primeros_digitos.length; i++) {
            if(i%2 == 0){
            array_2.push(primeros_digitos[i])
            }
        }
  
        for (i = 0; i < array_2.length; i++) {
            array_3.push(array_2[i]+array_2[i])
        }
  
  
        for (i = 0; i < array_3.length; i++) {
            if (array_3[i] <= 9 ){
            array_4.push(array_3[i])
            }
        }
        
        for (i = 0; i < array_3.length; i++) {
            if (array_3[i] >= 9 ){
            array_5.push(array_3[i]-9)
            }
        }
        
        let total_a = 0;
        let total_b = 0;
        array_6 = array_4.concat(array_5);
        array_6.forEach(function(a){total_b += a;});
        array_1.forEach(function(a){total_a += a;});
        let total = (parseInt(String(total_a+total_b).charAt(0))+1)*10
        if (total == 10){
            total = 0
        }

        if((total- (total_a+total_b)) == ultimo_digito  ){
            return true
        }else{
            mensaje("error","Error","La cedula es incorrecta");
            return false
        }
    };
};  


function mensaje(icon,title,text){
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
    })
}



function baseAjaxEdit(nameSelector,nameId,urlName,nameMethod,modalName,listCamps,nameSelectorId,nameSelectorModal,ExistSelect = false,selectId,ImagePreview = false, imageId){
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
                                    $("#"+selectId).selectpicker('render');
                                }else{
                                    item.removeAttribute("selected");
                                    $("#"+selectId).selectpicker('render');
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



var actualizarHora = function(){
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
    document.querySelector('.reloj').innerHTML =horas+":"+minutos+":"+segundos+"<div class='ampm'>&nbsp;"+ampm+"</div>";
};

actualizarHora();
var intervalo = setInterval(actualizarHora, 1000);