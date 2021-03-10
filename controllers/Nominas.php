<?php
    require_once ("./libraries/core/controllers.php");

    class Nominas extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(8);
        }

        public function nominas(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 8;
            $data["tag_pag"] = "Nominas";
            $data["page_title"] = "Nominas | Inicio";
            $data["page_name"] = "Listado de Nominas";
            $data['page'] = "nominas";
            $this->views->getView($this,"nominas",$data);
        }

        
        public function setNomina(){
            if ($_POST) {
                $intNomina = intval(strclean($_POST['id_nomina']));
                $nombre_nomina = strclean($_POST['nombre_nomina']);
                $periodo_inicio = strclean($_POST['periodo_inicio']);
                $periodo_fin = strclean($_POST['periodo_fin']);
                $estado_nomina = intval($_POST['estado_nomina']);
                $estado = intval($_POST['estadoInput']);

                if($intNomina == 0){
                    $request_nomina = $this->model->insertNomina($nombre_nomina,$periodo_inicio,
                    $periodo_fin,$estado_nomina,$estado);
                    $option = 1;
                }else{

                }

                if ($request_nomina > 0){ 
                    if (empty($_SESSION['permisos_modulo']['w'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                    }else{
                        if ($option == 1){
                            $data = array('status' => true, 'msg' => 'datos guardados correctamente');
                        }
                    }

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


        public function detalle(int $int_id_nomina){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 8;
            $data["tag_pag"] = "Detalle Nominas";
            $data["page_title"] = "Detalle nominas | Inicio";
            $data["page_name"] = "Detalle de nominas";
            $data["page"] = "detalle";

            $this->views->getView($this,"detalle",$data);
        }

        public function getNominaEmpleado(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $html_options = "";
                $data = $this->model->selectNominaEmpleado();
                if (count($data) > 0) {
                    for ($i=0; $i < count($data) ; $i++) { 
                        $html_options .='<option value="'.$data[$i]['id_empleado'].'">'.$data[$i]['nombre']." ".$data[$i]['apellido'].'</option>';
                    }
                }
                echo $html_options;                
                die();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }


        public function getSearchNominaEmpleado(int $int_id_empleado){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $intEmpleado  = Intval(strclean($int_id_empleado));
                if ($intEmpleado > 0){
                    $data = $this->model->selectSearchNominaEmpleado($int_id_empleado);
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
    }


?>