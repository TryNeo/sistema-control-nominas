<?php
    require_once ("./libraries/core/controllers.php");

    class Contratos extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(6);
        }

        public function contratos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            /*            
            if (empty($_SESSION['token'])) {
                $_SESSION['token'] = bin2hex(random_bytes(32));
            }
            $token = $_SESSION['token'];
            */

            $data["page_id"] = 6;
            $data["tag_pag"] = "Contratos";
            $data["page_title"] = "Contratos | Inicio";
            $data["page_name"] = "Tipos de contratos";
            $data['page'] = "contratos";
            $this->views->getView($this,"contratos",$data);
        }

        public function getContratos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectContratos();
                for ($i=0; $i < count($data); $i++) {
                    $btnEditarContrato = '';
                    $btnEliminarContrato = '';
                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }

                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarContrato = '<button  class="btn btn-primary btn-circle btnEditarContrato" title="editar" cont="'.$data[$i]['id_contrato'].'"><i class="fa fa-edit"></i></button>';
                    }

                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarContrato = '<button  class="btn btn-danger btn-circle btnEliminarContrato" title="eliminar" cont="'.$data[$i]['id_contrato'].'"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$i]['opciones'] = '<div class="text-center">'.$btnEditarContrato.' '.$btnEliminarContrato.'</div>';
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setContrato(){
            if ($_POST) {
                $intContrato = Intval(strclean($_POST['id_contrato']));
                $contratoInput = ucwords(strtolower(strclean($_POST["nombre_contrato"])));
                $descriInput = ucwords(strtolower(strclean($_POST["descripcion"])));
                $estadoInput = intval($_POST["estadoInput"]);

                if ($intContrato == 0){
                            $request_contrato = $this->model->insertContrato($contratoInput,$descriInput,$estadoInput);
                            $option = 1;
                            $_SESSION['token'] = bin2hex(random_bytes(32));
                }else{
                    $request_contrato = $this->model->updateContrato($intContrato,$contratoInput,$descriInput,$estadoInput);
                    $option = 2;
                    $_SESSION['token'] = bin2hex(random_bytes(32));
                }

                if ($request_contrato > 0){ 
                            if (empty($_SESSION['permisos_modulo']['w'])){
                                header('location:'.server_url.'Errors');
                                $data= array("status" => false, "msg" => "Error no tiene permisos");
                            }else{
                                if ($option == 1){
                                    $data = array('status' => true, 'msg' => 'datos guardados correctamente','token' => $_SESSION['token']);
                                }
                            }
        
                            if (empty($_SESSION['permisos_modulo']['u'])){
                                header('location:'.server_url.'Errors');
                                $data= array("status" => false, "msg" => "Error no tiene permisos");
                            }else{
                                if ($option == 2){
                                    $data = array('status' => true, 'msg' => 'datos actualizados correctamente','token' => $_SESSION['token']);
                                }
                            }
        
                }else if ($request_contrato == 'exist'){
                        $data = array('status' => false,'msg' => 'Error el contrato ya existe');
                    
                }else{
                        $data = array('status' => false,'msg' => 'Hubo un error no se pudo almacendar los datos');
                }
            }else{
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error Hubo problemas");
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        /*  */
        public function getContrato(int $id_contrato){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $int_id_contrato = Intval(strclean($id_contrato));
                if ($int_id_contrato > 0){
                    $data = $this->model->selectContrato($int_id_contrato);
                    if (empty($data)){
                        $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                    }else{
                        $data_response = array('status' => true,'msg'=> $data);
                    }
                }   
            }
            echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            die();
        }


        /* metodo que permite eliminar un contrato mediante su: id_contrato -> int*/
        public function delContrato(){
            /*
                comprobando que la $_SESSION['permisos_modulo']['r'] no se encuentre vacia , caso contrario 
                mandara un array transformado a JSON redicionara a una pagina de error 403
            */
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Oops!, al parecer no tiene los permisos correspondientes");
            }else{
                if($_POST){
                    if(empty($_POST)){
                        $data = array("status" => false, "msg" => "Oops!, no hay datos que procesar");
                    }else{
                        /* Obteniendo el id del contrato y limpiandolo para evitar injection SQL */
                        $int_id_contrato = intval(strclean($_POST["id"]));
                        /* comprobando que no este vacio */
                        if(empty($int_id_contrato)){
                            $data = array("status" => false, "msg" => "Oops!, no existe tal contrato o estas mandado datos erroneos");
                        }else{
                            /* Obteniendo una respuesta ok o exist:
                                ok -> el dato ha sido eliminado correctamente
                                exist -> el dato esta vinculado con un fk a otra tabla y no es posible dicha eliminacion
                            */
                            $response_delete = $this->model->deleteContrato($int_id_contrato);
                            if($response_delete == "ok"){
                                $data = array("status" => true, "msg" => "El contrato ha sido eliminado correctamente");
                            }else if ($response_delete == "exist"){
                                $data = array("status" => false, "msg" => "No es posible eliminar contrato asociado a un empleado");
                            }else{
                                $data = array("status" => false, "msg" => "Oops!, hubo problemas no se pudo eliminar el contrato o no existe");
                            }
                        }
                    }   
                }else{
                    $data = array("status" => false, "msg" => "Oops!,el proceso es erroneo");
                }
            }
            /* imprimiendo un JSON, con la variable $data , para mostrar dichos mensajes definidos */
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


        /* metodo que permite obtener :  id_contrato -> int ,nombre_contrato -> str
            para mandarlo a un <select></select> ya definido mediante un ajax
        */
        public function getSelectContratos(){  
            /*  comprobando que la $_SESSION['permisos_modulo']['r'] no se encuentre vacia , caso contrario 
                mandara un array transformado a JSON redicionara a una pagina de error 403
            */
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $select_options = "";
                /* data retornara un array con los contractos Activos , mediante el $this->model->selectContratosNoInactivos();*/
                $data = $this->model->selectContratosNoInactivos();
                if (count($data) > 0) {
                    for ($i=0; $i < count($data) ; $i++) { 
                        $select_options .='<option value="'.$data[$i]['id_contrato'].'">'.$data[$i]['nombre_contrato'].'</option>';
                    }
                }
                /* imprimiendo las opciones ya definidas con su value, y contenido */
                echo $select_options;                
                die();
            }
            /* imprimiendo un JSON, con la variable $data , para mostrar dicho mensaje de error */
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }

?>