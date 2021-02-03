function validate(rolInput,descriInput,estadoInput){
    if ((rolInput === "") || (descriInput === "") || (estadoInput === "")){
        return mensaje("error","Error","Todos los campos son obligatorios");
    }else{
        let rol = isValidString(rolInput);
        let descript = isValidString(descriInput);
        if ((rol === true && descript === true)){
            return true;
        }else{
            mensaje("error","Error","Los campos ingresados no son validos")
            return false;
        }
    }
 
}


function isValidString(str1) {
    const validRegEx = /^[^\\\/&]*$/
    if(typeof str1 === 'string' && str1.match(validRegEx) && str1.length > 5) {
        return true;
    } else {
        return false;
    }
  }

  
function mensaje(icon,title,text){
    Swal.fire({
        icon: icon,
        title: title,
        text: text,
      })
}


