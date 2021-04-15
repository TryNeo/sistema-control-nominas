<?php
    require_once ("./libraries/core/controllers.php");

    class Puestos extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(7);
        }

        public function puestos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 7;
            $data["tag_pag"] = "Puestos";
            $data["page_title"] = "Puestos | Inicio";
            $data["page_name"] = "Listado de Puestos";
            $data['page'] = "puestos";
            $this->views->getView($this,"puestos",$data);
        }

        public function getPuestos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectPuestos();
                for ($i=0; $i < count($data); $i++) {
                    $btnEditarPuesto = '';
                    $btnEliminarPuesto = '';
                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-sm">
                        <i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-sm">
                        <i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }

                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarPuesto = '<button  class="btn btn-primary btn-circle btnEditarPuesto" 
                        title="editar" puest="'.$data[$i]['id_puesto'].'"><i class="fa fa-edit"></i></button>';
                    }

                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarPuesto = '<button  class="btn btn-danger btn-circle 
                        btnEliminarPuesto" title="eliminar" puest="'.$data[$i]['id_puesto'].'"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$i]['opciones'] = '<div class="text-center">'.$btnEditarPuesto.' '.$btnEliminarPuesto.'</div>';
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setPuesto(){
            if ($_POST) {
                $id_puesto = intval(strclean($_POST['id_puesto']));
                $nombre_puesto = ucwords(strtolower(strclean($_POST['nombre_puesto'])));
                $descripcion_puesto= ucwords(strtolower(strclean($_POST['descripcion'])));
                $estado_puesto= intval(strclean($_POST['estadoInput']));
                $validate_data = [$id_puesto,$nombre_puesto,$descripcion_puesto,$estado_puesto];
                $validate_data_regex = [$nombre_puesto,$descripcion_puesto];
                $validate_data_regex_numbers = [$estado_puesto,$id_puesto];
                if(validateEmptyFields($validate_data)){
                    if(empty(preg_matchall($validate_data_regex,regex_string)) &&
                        empty(preg_matchall($validate_data_regex_numbers,regex_numbers))){
                        if ($id_puesto == 0){
                            $response_puesto = $this->model->insertPuesto($nombre_puesto,$descripcion_puesto,$estado_puesto);
                            $option = 1;
                        }else{
                            $response_puesto = $this->model->updatePuesto($id_puesto,$nombre_puesto,$descripcion_puesto,$estado_puesto);
                            $option = 2;
                        }
                
                        if ($response_puesto > 0){ 
                            if (empty($_SESSION['permisos_modulo']['w'])){
                                header('location:'.server_url.'Errors');
                                $data= array("status" => false, "msg" => "Error no tiene permisos");
                            }else{
                                if ($option == 1){
                                    $data = array('status' => true, 'msg' => 'datos guardados correctamente');
                                }
                            }
        
                            if (empty($_SESSION['permisos_modulo']['u'])){
                                header('location:'.server_url.'Errors');
                                $data= array("status" => false, "msg" => "Error no tiene permisos");
                            }else{
                                if ($option == 2){
                                    $data = array('status' => true, 'msg' => 'datos actualizados correctamente');
                                }
                            }
        
                        }else if ($response_puesto == 'exist'){
                                $data = array('status' => false,'msg' => 'Error el puesto ya existe');
                            
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

        public function getPuesto(int $id_puesto){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $id_puesto = Intval(strclean($id_puesto));
                if(validateEmptyFields([$id_puesto])){
                    if(empty(preg_matchall([$id_puesto],regex_numbers))){
                        if ($id_puesto > 0){
                            $data = $this->model->selectPuesto($id_puesto);
                            if (empty($data)){
                                $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                            }else{
                                $data_response = array('status' => true,'msg'=> $data);
                            }
                        }  
                    }else{
                        $data_response = array('status' => false,'msg' => 'Algunos de tus campos estan mal escritos , verifique y vuelva a ingresarlos');
                    }
                }else{
                    $data_response = array('status' => false,'msg' => 'Algunos campos aun estan vacios , verifique y vuelva a ingresarlos');
                }
            }
            echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function delPuesto(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if($_POST){
                    $id_puesto = intval(strclean($_POST["id"]));
                    if(validateEmptyFields([$id_puesto])){
                        if(empty(preg_matchall([$id_puesto],regex_numbers))){
                            $response_del = $this->model->deletePuesto($id_puesto);
                            if($response_del == "ok"){
                                $data = array("status" => true, "msg" => "Se ha eliminado el contracto");
                            }else if ($response_del == "exist"){
                                $data = array("status" => false, "msg" => "No es posible eliminar puesto asociado a un empleado");
                            }else{
                                $data = array("status" => false, "msg" => "Error al eliminar contracto");
                            }
                        }else{
                            $data = array('status' => false,'msg' => 'Algunos de tus campos estan mal escritos , verifique y vuelva a ingresarlos');
                        }
                    }else{
                        $data = array('status' => false,'msg' => 'Algunos campos aun estan vacios , verifique y vuelva a ingresarlos');
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getSelectPuestos(){   
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $html_options = "";
                $data = $this->model->selectPuestosNoInactivos();
                if (count($data) > 0) {
                    for ($i=0; $i < count($data) ; $i++) { 
                        $html_options .='<option value="'.$data[$i]['id_puesto'].'">'.$data[$i]['nombre_puesto'].'</option>';
                    }
                }
                echo $html_options;                
                die();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }

    }
?>