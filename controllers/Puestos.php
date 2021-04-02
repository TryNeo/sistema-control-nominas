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
                $intPuesto = intval($_POST['id_puesto']);
                $puestoInput = ucwords(strtolower(strclean($_POST['nombre_puesto'])));
                $descriInput = ucwords(strtolower(strclean($_POST['descripcion'])));
                $estadoInput = intval($_POST['estadoInput']);
                
                if ($intPuesto == 0){
                    $request_puesto = $this->model->insertPuesto($puestoInput,$descriInput,$estadoInput);
                    $option = 1;
                }else{
                    $request_puesto = $this->model->updatePuesto($intPuesto,$puestoInput,$descriInput,$estadoInput);
                    $option = 2;
                }
        
                if ($request_puesto > 0){ 
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

                }else if ($request_puesto == 'exist'){
                        $data = array('status' => false,'msg' => 'Error el puesto ya existe');
                    
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

        public function getPuesto(int $id_puesto){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $int_id_puesto = Intval(strclean($id_puesto));
                if ($int_id_puesto > 0){
                    $data = $this->model->selectPuesto($int_id_puesto);
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


        public function delPuesto(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if($_POST){
                    $int_id_puesto = intval($_POST["id"]);
                    $request_del = $this->model->deletePuesto($int_id_puesto);
                    if($request_del == "ok"){
                        $data = array("status" => true, "msg" => "Se ha eliminado el contracto");
                    }else if ($request_del == "exist"){
                        $data = array("status" => false, "msg" => "No es posible eliminar puesto asociado a un empleado");
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