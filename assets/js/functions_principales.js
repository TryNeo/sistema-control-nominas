document.addEventListener('DOMContentLoaded',function(){
    fntRestaurarPassword();
})

/**
 * @const {string} base_url - contiene una la url definida , usada como el corazon para consultas y/o redireciones.
 * @const {string} base_url_image - contiene un url que direciona a un path /assets/images,usada para mostrar ciertas imaenes ya predefinidas.
 * @const {regex} regex_string  - contiene una exprecion regular que acepta letras y espacios.
 * @const {regex} regex_numbers - contiene una exprecion regular que acepta numeros solamente.
 * @const {regex} regex_username_password - contiene una exprecion regular que acepta letras y numeros y caracteres especiales.
 */
const base_url = "http://localhost/sistema-control-nominas/";
const base_url_image = "http://localhost/sistema-control-nominas/assets/images/";
const regex_string = '^[a-zA-ZáéíóñÁÉÍÓÚÑ ]+$';
const regex_numbers = '^[0-9]+$';
const regex_fechas = '^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$';
const regex_username_password = '^[a-zA-Z0-9_-]{4,18}$';
const regex_email = '^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$';
/**
 * Funcion cerrar_modal - cierra el modal con un selector definido,
 * @param {selector} nameSelector - acepta un selector de tipo id o class.
 * */
function cerrar_modal(nameSelector){
    $(nameSelector).modal("hide");
}

/**
 * Funcion mensaje - permite mostrar una alerta con la libreria swealert 
 * @param  {string} icon - recibe el tipo de icono /error/success/info/warning
 * @param  {string} title - recibe el tipo de titulo a mostrar en la alertar
 * @param  {string} text - recibe el mensaje de error a mostrar
 */
function mensaje(icon,title,text){
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
    })
}

/**
 * Funcion validateEmptyFields  - permite validar,que los campos no se encuentre vacios.
 * @param  {Array} listFields - acepta una lista con cierta cantidad de datos o un string/number.
 * @return {boolean} - retornara true o false , si algo esta correcto o incorrecto.
 **/
function validateEmptyFields(listFields){
    if (typeof(listFields) === 'object'){
        let errorFields= new Array();
        let validFields = new Array();
        listFields.forEach(function(elements, index){
            let fields = (listFields[index] === "") ? errorFields.push(listFields[index]) : validFields.push(listFields[index]);
        });
    
        if (errorFields.length > 0){
            mensaje("error","Campos vacios","Todos los campos son requeridos");
            return false;
        }else{
            return true;
        }
    }else{
        if(listFields === ''){
            mensaje("error","Campo vacio","El campo es requerido");
            return false;
        }else{
            return true;
        }
    }

}

/**
 * Funcion validateInnput - valida que los campos sea validos con las expreciones regulares.
 * @param  {Array} listFields - acepta una lista con cierta cantidad de datos sea string/number.
 * @param  {regex} regex_string - acepta una expresion regular definida por el usuario 
 * @param  {regex} regex_numbers ='' - acepta una expresion regular tipo number, por defecto estara vacio
 * @return {boolean} - retornara true o false , si algo esta correcto o incorrecto . 
 **/
function validateInnput(listFields,regex_string,regex_numbers = ''){
    let errorFields= new Array();
    let validFields = new Array();
    if(typeof(listFields) === 'object'){
        if(regex_numbers === ''){
            listFields.forEach((value, index) => {
                let valid_string = (
                        String(listFields[index]
                            ).match(regex_string) === null) ? errorFields.push(listFields[index]) : validFields.push(listFields[index]) 
            })
        }else{
            listFields.forEach((value, index) => {
                if (typeof(listFields[index]) === 'number'){
                    let valid_number = (
                        String(listFields[index]
                            ).match(regex_numbers) === null) ? errorFields.push(listFields[index]) : validFields.push(listFields[index]) 
                }else{
                    let valid_string =  (
                        String(listFields[index]
                            ).match(regex_string) === null) ? errorFields.push(listFields[index]) : validFields.push(listFields[index])
                }
            })
        }
        if (errorFields.length > 0){
            mensaje("error","Sintaxis Error","Los campos "+errorFields+" estan mal escritos,introduzca un texto valido");
            return false;
        }else{
            return true;
        }
    }else{
        return false;
    }
}

/**
 * Funcion validateCedula - valida que la cedula ingresa sea valida.
 * @param  {string} cedula -recibe  un string con una cantidad de numeros de 10 digitos
 * @return {boolean} - retornara true o false , si algo esta correcto o incorrecto . 
 */
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
            mensaje("error","Error","La cedula Ingresada no fue valida")
            return false
        }
    
        }
}



/**
 * funcion fetchEdit - funcion base para las ediciones respectivas , moldeado al gusto de de las acciones
 * @param  {string} nameSelector - recibe el nombre de un selector sea id o class
 * @param  {string} nameId - recibe el nombre de un selector tipo id
 * @param  {string} urlName - recibe el nombre del metodo al que hace llamado
 * @param  {string} nameMethod - recibe el nombre del metodo  a utilizar
 * @param  {string} modalName - recibe el nombre de un modal tipo id,
 * @param  {list} listCamps - recibe una listas de campos string o numbers
 * @param  {string} nameSelectorId - recibe el nombre del selector tipo id
 * @param  {string} nameSelectorModal - recibe el nombre del modal selector
 * @param  {boolean} ExistSelect =false - recibe un boolean 
 * @param  {string} selectId - recibe un selector tipo id
 * @param  {boolean} ImagePreview =false - recibe un boolean
 * @param  {string} imageId - recibe un selector tipo id
 * @param  {boolean} ExistSelect_two =false - recibe un boolean
 * @param  {string} selectId_two - recibe un select segundo tipo id
 */
async function fetchEdit(nameSelector,nameId,urlName,nameMethod,modalName,listCamps,
            nameSelectorId,nameSelectorModal,ExistSelect = false,selectId,ImagePreview = false, imageId,ExistSelect_two = false,selectId_two){
    let btnBaseEdit = document.querySelectorAll(nameSelector);
    btnBaseEdit.forEach(function(btnBaseEdit){
        btnBaseEdit.addEventListener('click',function(){
            document.querySelector('#modalTitle').innerHTML = modalName;
            document.querySelector('.text-center').innerHTML = " Actualizar registro";
            document.querySelector('#btnDisabled').style.display = 'none';
            let id = this.getAttribute(nameId);
            (async () => {
                try {
                    let options = { method: "GET"}
                    let response = await fetch(base_url+urlName+"/"+nameMethod+"/"+id,options);
                    if (response.ok) {
                        let data = await response.json();
                        if(data.status){
                            document.querySelector('#'+nameSelectorId).value = data.msg[nameSelectorId];
                            listCamps.forEach(function(element,index){
                                document.querySelector('#'+element).value = data.msg[element];
                            })

                            if (ImagePreview){
                                    document.querySelector(imageId).innerHTML ="<img src='"+base_url_image+data.msg['foto']+"'  class='img-100 img-fluid' ></div>";
                            }

                            if(ExistSelect){
                                let a = document.querySelector("#"+selectId).getElementsByTagName('option');
                                for (let item of a){
                                    if (item.value === data.msg[selectId]) {
                                        item.setAttribute("selected","");
                                    }else{
                                        item.removeAttribute("selected");
                                    }
                                }
                            }

                            if(ExistSelect_two){
                                    let b = document.querySelector("#"+selectId_two).getElementsByTagName('option');
                                    for (let item of b){
                                        if (item.value === data.msg[selectId_two]) {
                                            item.setAttribute("selected","");
                                        }else{
                                            item.removeAttribute("selected");
                                        }
                                    }
                            }

                            const optionsSelect = document.querySelector("#estadoInput") .getElementsByTagName("option"); 
                            for (let item of optionsSelect ) {
                                    if (item.value == data.msg.estado) {
                                        item.setAttribute("selected","");
                                    } else {
                                        item.removeAttribute("selected");
                                    }
                            }
                            
                            $(nameSelectorModal).modal("hide");
                        }else{
                            mensaje("error","Error",data.msg);
                        }
                    }else {
                        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                    }
                } catch (err) {
                    mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
                }
                $(nameSelectorModal).modal("show");
            })();
        });
    });
}

/**
 * Funcion fetchDelete - funcion base para las eliminaciones respectivas moldead al gusto de las acciones
 * @param  {string} nameSelector - recibe el nombre de un selector sea id o class
 * @param  {string} nameId  - recibe el nombre de un selector tipo id
 * @param  {string} urlName - recibe el nombre del metdo al que hace llamado
 * @param  {string} nameMethod -recibe el nombre del metodo a utilizar
 * @param  {string} title - recibe el titulo del mensaje de alerta
 * @param  {string} text -  recibe el texto del mensaje de alerta
 * @param  {string} modalName - recibe un nombre tipo selector id o class
 * @param  {variable} tableupdate - recibe una variable la cual va actualizar la datatable de manera eficaz
 */
async function fetchDelete(nameSelector,nameId,urlName,nameMethod,title,text,modalName,tableupdate){
    let btnBaseDelete = document.querySelectorAll(nameSelector);
    btnBaseDelete.forEach(function(btnBaseDelete){
        btnBaseDelete.addEventListener('click',function(){
            let id = this.getAttribute(nameId);
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
                    (async () => {
                        try {
                            let data = new FormData();data.append("id",id);
                            let options = { method: "POST", body :data}
                            let response = await fetch(base_url+urlName+"/"+nameMethod,options);
                            if (response.ok) {
                                let data = await response.json();
                                if(data.status){
                                    $(modalName).modal("hide");
                                    mensaje("success","Exitoso",data.msg);
                                    tableupdate.ajax.reload();
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

/**
 * Funcion fetchSelect - funcin base para mostrar elementos en select predeterminados 
 * @param  {string} nameSelector - recibe el nombre de un selector sea id o class
 * @param  {string} nameMethod - recibe el nombre del metodo a utilizar
 * @param  {string} urlName - recibe el el nombre de la url a usar
 * @param  {string} nameMensaje - recibe el mensaje por default a usar 
 */
async function fetchSelect(nameSelector,nameMethod,urlName,nameMensaje){
    try {
        let options = { method: "GET"}
        let response = await fetch(base_url+urlName+"/"+nameMethod,options);
        if (response.ok) {
            let data = await response.text();
            if(document.querySelector("#"+nameSelector) !=null){
                document.querySelector("#"+nameSelector).innerHTML = "<option  selected disabled='disabled'  value=''>"+nameMensaje+"</option>"+data;
            }
        }else {
            mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
        }
    } catch (err) {
        mensaje("error","Error | Peticion Ajax","Oops hubo un error al realizar la peticion")
    }
};

/**
 * Funcion fntRestauarPassword - una funcion que permite restaurar la contraseña del usuario
 * @param {int} id_usuario - recibe el id el usuario actualizar
 * @param {string} password - recibe la nueva contraseña de usuario
 * @param {string} password_rep - recibe la misma contraseña para validar si son iguales
 * @return {json} message - retornara un json con datos true/false
 */
async function fntRestaurarPassword(){
    let formRestaurar = document.querySelector('#formRestaurar');
    if(formRestaurar !=null){
        formRestaurar.addEventListener('submit', (e) => {
            e.preventDefault();
            let id_usuario =  document.querySelector('#id_usuario_ses').value;
            let password_usuario = document.querySelector('#password_new').value;
            let password_rep_usuario = document.querySelector('#rep_password').value;
            let validate_data = [password_usuario,password_rep_usuario,id_usuario];
            let validate_data_regex = [password_usuario,password_rep_usuario];
            if(validateEmptyFields(validate_data)){
                if(validateInnput(validate_data_regex,regex_username_password) && validateInnput([id_usuario],regex_numbers)){
                    if (password_usuario === password_rep_usuario){
                        (async () => {
                            try {
                                let data = new FormData(formRestaurar);
                                let options = { method: "POST", body :data}
                                let response = await fetch(base_url+"usuarios/resUsuario",options);
                                if (response.ok) {
                                    let data = await response.json();
                                    if(data.status){
                                        mensaje("success","Exitoso",data.msg);
                                        $('#modalRestaurar').modal("hide");
                                        password_usuario.value='';password_rep_usuario.value = '';
                                        setTimeout(function(){window.location.replace(base_url+"logout")},1500);
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
                    }else{
                        return mensaje("error","Contraseñas no validas","Las contraseñas no coinciden,verifique y vuelva a intentarlo")
                    }
                }else{
                    return validateInnput(validate_data_regex,regex_username_password),validateInnput([id_usuario],regex_numbers);
                }
            }else{
                return validateEmptyFields(validate_data);
            }
        });        
    }
}





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


function printPdf(idFrame){
    let objFra = document.getElementById(idFrame);
    objFra.contentWindow.focus();
    objFra.contentWindow.print();
}


function abrir_modal_reporte(idModal){
    let options = {
        "backdrop" : "static",
        "keyboard": false,
        "show":true
    }
    $('#'+idModal).modal(options);
}

