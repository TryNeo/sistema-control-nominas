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
                $id_contrato = (strclean($_POST['id_contrato'] === '')) ? 0 : Intval(strclean($_POST['id_contrato']));
                $nombre_contrato = ucwords(strtolower(strclean($_POST["nombre_contrato"])));
                $descripcion_contrato = ucwords(strtolower(strclean($_POST["descripcion"])));
                $estado_contrato = intval(strclean($_POST["estadoInput"]));
                $validate_data = array($nombre_contrato,$descripcion_contrato);
                $validate_data_numbers = array($id_contrato,$estado_contrato);
                if (validateEmptyFields($validate_data)){
                    if(empty(preg_matchall($validate_data,regex_string)) && empty(preg_matchall($validate_data_numbers,regex_numbers))){
                        if ($id_contrato == 0){
                            $response_contrato = $this->model->insertContrato($nombre_contrato,$descripcion_contrato,$estado_contrato);
                            $option = 1;
                        }else{
                            $response_contrato = $this->model->updateContrato($id_contrato,$nombre_contrato,$descripcion_contrato,$estado_contrato);
                            $option = 2;
                        }
                        if ($response_contrato > 0){ 
                            if (empty($_SESSION['permisos_modulo']['w'])){
                                header('location:'.server_url.'Errors');
                            }else{
                                if ($option == 1){
                                    $data = array('status' => true, 'msg' => 'datos guardados correctamente');
                                }
                            }
                            if (empty($_SESSION['permisos_modulo']['u'])){
                                header('location:'.server_url.'Errors');
                            }else{
                                if ($option == 2){
                                    $data = array('status' => true, 'msg' => 'datos actualizados correctamente');
                                }
                            }
                        }else if ($response_contrato == 'exist'){
                                $data = array('status' => false,'msg' => 'El contrato ya existe, ingrese uno nuevo');
                        }else{
                                $data = array('status' => false,'msg' => 'Hubo un error no se pudo almacendar los datos');
                        }
                    }else{
                        $data = array('status' => false,'msg' => 'Algunos de tus campos estan mal escritos , verifique y vuelva a ingresarlos');
                    }
                }else{
                    $data = array('status' => false,'msg' => 'Algunos campos aun estan vacios , verifique y vuelva a ingresarlos');
                }
            }else{
                header('location:'.server_url.'Errors');
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getContrato(int $id_contrato){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $id_contrato = (Intval(strclean($id_contrato)) > 0 ) ? Intval(strclean($id_contrato)) : '' ;
                if(empty(preg_matchall([$id_contrato],regex_numbers))){
                    $data = $this->model->selectContrato($id_contrato);
                    if (empty($data)){
                        $data_response = array('status' => false,'msg'=> 'Datos no encontrados, intentelo de nuevo');
                    }else{
                        $data_response = array('status' => true,'msg'=> $data);
                    }
                }else{
                    $data_response = array('status' => false,'msg' => 'Oops!, El campo no es valido, verifiquelo y vuelva a intentarlo');
                }
            }
            echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function delContrato(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Oops!, al parecer no tiene los permisos correspondientes");
            }else{
                if($_POST){
                    if(empty($_POST)){
                        $data = array("status" => false, "msg" => "Oops!, no hay datos que procesar");
                    }else{
                        $id_contrato = (intval(strclean($_POST["id"])) > 0 ) ? intval(strclean($_POST["id"])) : '';
                        $validate_data = array($id_contrato);
                        if (validateEmptyFields($validate_data)){
                            if(empty(preg_matchall($validate_data,regex_numbers))){
                                $response_delete = $this->model->deleteContrato($id_contrato);
                                if($response_delete == "ok"){
                                    $data = array("status" => true, "msg" => "El contrato ha sido eliminado correctamente");
                                }else if ($response_delete == "exist"){
                                    $data = array("status" => false, "msg" => "No es posible eliminar contrato asociado a un empleado");
                                }else{
                                    $data = array("status" => false, "msg" => "Oops!, hubo problemas no se pudo eliminar el contrato o no existe");
                                }
                            }else{
                                $data = array('status' => false,'msg' => 'Oops!, El campo no es valido');
                            }
                        }else{
                            $data = array("status" => false, "msg" => "Oops!, no existe tal contrato o estas mandado datos erroneos");
                        }
                    }   
                }else{
                    $data = array("status" => false, "msg" => "Oops!,el proceso es erroneo");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getSelectContratos(){  
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $select_options = "";
                $data = $this->model->selectContratosNoInactivos();
                if (count($data) > 0) {
                    for ($i=0; $i < count($data) ; $i++) { 
                        $select_options .='<option value="'.$data[$i]['id_contrato'].'">'.$data[$i]['nombre_contrato'].'</option>';
                    }
                }
                echo $select_options;                
                die();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }
