function validateCamps(listCamps){
  var newlistCamps = new Array();
  var errorCamps = new Array();
  var validCamps = new Array();
  
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
     newlistCamps.forEach(function(elements,index){
        if(isValidString(newlistCamps[index])){
            validCamps.push(newlistCamps[index]);
        }else{
            errorCamps.push(newlistCamps[index]);
        }
      });
      
      if(errorCamps.length > 0){
        mensaje("error","Error","Los campos ingresados no son validos")
        return false;
      }else{
        return true;
      }
    }
}


function isValidString(str1) {
  const validRegEx = "^[a-zA-Z 0-9]+$";
  if(typeof str1 === "number"){
    return true;
  }

  if(String(str1).match(validRegEx) && str1.trim()) {
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


