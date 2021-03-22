<?php
    require_once ("./libraries/core/controllers.php");

    class Dashboard extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(1);
        }

        public function dashboard(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 1;
            $data["tag_pag"] = "Dashboard";
            $data["page_title"] = "Dashboard | Inicio";
            $data["page_name"] = "dashboard";
            $data["page"] = "dashboard";
            $data["total_empleados"] = $this->model->getTotalEmpleado();
            $data["total_nominas"] = $this->model->getTotalNominas();
            $data["total_usuarios"] = $this->model->getTotalUsuarios();
            $data["total_general"]  = ($this->model->getTotalGeneral()[0]['total']>=1) ? number_format($this->model->getTotalGeneral()[0]['total'],0,".",",") : 0.00;
            $this->views->getView($this,"dashboard",$data);

        }

        

        public function graphEstadoNominas(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }else{
                $estado_pendiente = ($this->model->getEstadoPediente()>=1) ? $this->model->getEstadoPediente(): 0.00 ;
                $estado_aceptado  = ($this->model->getEstadoAceptado()>=1) ? $this->model->getEstadoAceptado(): 0.00 ;
                $estado_rechazado = ($this->model->getEstadoRechazado()>=1) ? $this->model->getEstadoRechazado(): 0.00 ;
                $data = array(
                            array("name" => "Rechazado", "y" => round(intval($estado_rechazado[0]['rechazado']),2)),
                            array("name" => "Pediente", "y" => round(intval($estado_pendiente[0]['pendiente']),2)),
                            array("name" => "Aceptado", "y" => round(intval($estado_aceptado[0]['aceptado']),2)));
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function grahpNominaTotal(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }else{
                $data = '';
                $nomina_totales = $this->model->getNominaTotal();
                if ($nomina_totales >= 1) {
                    $data = json_encode($nomina_totales,JSON_UNESCAPED_UNICODE);
                }else{
                    $data = json_encode(array(),JSON_UNESCAPED_UNICODE);
                }
            }
            echo $data;
            die();
        }
    }


?>
