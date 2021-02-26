<?php
    require_once ("./libraries/core/controllers.php");

    class Contractos extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            session_regenerate_id(true);
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }else{
                if(time()-$_SESSION["login_time_stamp"] >1800)   
                { 
                    session_unset(); 
                    session_destroy(); 
                    header('location:'.server_url.'logout');
                } 
            }
            getPermisos(6);
        }

        public function contractos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 6;
            $data["tag_pag"] = "Contractos";
            $data["page_title"] = "Contractos | Inicio";
            $data["page_name"] = "Tipos de contractos";
            $data['page'] = "contractos";
            $this->views->getView($this,"contractos",$data);
        }

        public function getContractos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectContractos();
                for ($i=0; $i < count($data); $i++) {
                    $btnEditarContracto = '';
                    $btnEliminarContracto = '';
                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }

                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarContracto = '<button  class="btn btn-primary btn-circle btnEditarContracto" title="editar" cont="'.$data[$i]['id_contracto'].'"><i class="fa fa-edit"></i></button>';
                    }

                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarContracto = '<button  class="btn btn-danger btn-circle btnEliminarContracto" title="eliminar" cont="'.$data[$i]['id_contracto'].'"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$i]['opciones'] = '<div class="text-center">'.$btnEditarContracto.' '.$btnEliminarContracto.'</div>';
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setContracto(){
            if ($_POST) {
                $intContracto = Intval(strclean($_POST['id_contracto']));
                $contractoInput = strclean($_POST["nombre_contracto"]);
                $descriInput = strclean($_POST["descripcion"]);
                $estadoInput = intval($_POST["estadoInput"]);

                if ($intContracto == 0){
                    $request_contracto = $this->model->insertContracto($contractoInput,$descriInput,$estadoInput);
                    $option = 1;
                }else{
                    $request_contracto = $this->model->updateContracto($intContracto,$contractoInput,$descriInput,$estadoInput);
                    $option = 2;
                }

                if ($request_contracto > 0){ 
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

                }else if ($request_contracto == 'exist'){
                        $data = array('status' => false,'msg' => 'Error el contracto ya existe');
                    
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

        public function getContracto(int $id_contracto){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $int_id_contracto = Intval(strclean($id_contracto));
                if ($int_id_contracto > 0){
                    $data = $this->model->selectContracto($int_id_contracto);
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

        public function delContracto(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if($_POST){
                    $int_id_contracto = intval($_POST["id"]);
                    $request_del = $this->model->deleteContracto($int_id_contracto);
                    if($request_del == "ok"){
                        $data = array("status" => true, "msg" => "Se ha eliminado el contracto");
                    }else if ($request_del == "exist"){
                        $data = array("status" => false, "msg" => "No es posible eliminar contracto asociado a un empleado");
                    }else{
                        $data = array("status" => false, "msg" => "Error al eliminar contracto");
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getSelectContractos()
        {   
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $html_options = "";
                $data = $this->model->selectContractosNoInactivos();
                if (count($data) > 0) {
                    for ($i=0; $i < count($data) ; $i++) { 
                        $html_options .='<option value="'.$data[$i]['id_contracto'].'">'.$data[$i]['nombre_contracto'].'</option>';
                    }
                }
                echo $html_options;                
                die();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }

?>