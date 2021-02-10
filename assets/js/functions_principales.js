function validateCamps(listCamps){
  let newlistCamps = new Array();
  let errorCamps = new Array();
  let validCamps = new Array();
  
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

function cerrar_modal(nameSelector){
    $(nameSelector).modal("hide");
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




function baseAjaxEdit(nameSelector,nameId,urlName,nameMethod,modalName,listCamps,nameSelectorId,nameSelectorModal,ExistSelect = false,selectId){
  let btnBaseEdit = document.querySelectorAll(nameSelector);
      btnBaseEdit.forEach(function(btnBaseEdit){
          btnBaseEdit.addEventListener('click',function(){
              document.querySelector('#modalTitle').innerHTML = modalName;
              document.querySelector('.text-center').innerHTML = " Actualizar registro";
              document.querySelector('#btnDisabled').style.display = 'none';
              let id = this.getAttribute(nameId);
              let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
              let ajaxEdUser = "http://localhost/sistema-control-nominas/"+urlName+"/"+nameMethod+"/"+id;
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

                          if(ExistSelect){
                            let a = document.querySelector("#"+selectId).getElementsByTagName('option');
                            for (let item of a){
                                if (item.value ===  objData.msg.id_rol) {
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
                                  console.log(item.value);
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


function baseAjaxDelete(nameSelector,nameId,urlName,nameMethod,title,text,modalName){
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
                    let ajaxUrl = "http://localhost/sistema-control-nominas/"+urlName+"/"+nameMethod;
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

