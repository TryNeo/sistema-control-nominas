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
            $data["total_general"]  = ($this->model->getTotalGeneral()[0]['total']>=1) ? number_format($this->model->getTotalGeneral()[0]['total']) : 0.00;
            $this->views->getView($this,"dashboard",$data);

        }

        

        public function graphEstadoNominas(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }else{
                $estado_pendiente = ($this->model->getEstadoPediente()>=1) ? $this->model->getEstadoPediente(): 0;
                $estado_aceptado  = ($this->model->getEstadoAceptado()>=1) ? $this->model->getEstadoAceptado(): 0;
                $estado_rechazado = ($this->model->getEstadoRechazado()>=1) ? $this->model->getEstadoRechazado(): 0;
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

        public function grahpEmpleadosTotal(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }else{
                $data = '';
                $array_empleados_total =  array();
                $empleados_totales = $this->model->getEmpleadosNominasTotal();
                if ($empleados_totales >= 1) {
                    foreach ($empleados_totales as $key => $value ) {
                        array_push($array_empleados_total, array(
                            "name" =>$empleados_totales[$key]['nombre']." ".$empleados_totales[$key]['apellido'],
                            "y" => $empleados_totales[$key]['total'],
                            "drilldown" => $empleados_totales[$key]['id_empleado'],
                        ));
                    }
                    $data = json_encode($array_empleados_total,JSON_UNESCAPED_UNICODE);
                }else{
                    $data = json_encode($array_empleados_total,JSON_UNESCAPED_UNICODE);
                }
            }
            echo $data;
            die();
        }

        public function grahpEmpleadosGeneral(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }else{
                $array_empleados_nomina = array();
                $id_empleados_total = $this->model->getEmpleadosNominasTotal();
                if ($id_empleados_total >= 1) {
                    foreach ($id_empleados_total as $key => $value) {
                        $response = $this->model->getEmpleadosNominasGeneral($id_empleados_total[$key]['id_empleado']);
                        if($response >= 1){
                            array_push($array_empleados_nomina,
                                array(
                                    "name"=>$id_empleados_total[$key]['nombre']." ".$id_empleados_total[$key]['apellido'],
                                    "id" =>$id_empleados_total[$key]['id_empleado'],
                                    "data" => $response,
                                )
                            );
                        }
                    }
                    $data = json_encode($array_empleados_nomina,JSON_UNESCAPED_UNICODE);
                }else{
                    $data = json_encode($array_empleados_nomina,JSON_UNESCAPED_UNICODE);
                }

            }
            echo $data;
            die();
        }

        public function getEmpleadosNow(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }else{
                $response_empleados = $this->model->getEmpleadosRecientes();
                if ($response_empleados >= 1){
                    foreach ($response_empleados as $key => $value) {
                        echo '<tr scope="row">';
                        echo "<td>".$response_empleados[$key]['nombre']."</td>";
                        echo "<td>".$response_empleados[$key]['sueldo']."</td>";
                        echo "<td>".$response_empleados[$key]['nombre_puesto']."</td>";
                        echo '</tr>';
                    }
                }else{
                    echo '<tr><td></td><td></td><td></td></tr>';
                }
            }
            die();
        }

        public function getNominasNow(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }else{
                $response_nominas = $this->model->getNominasRecientes();
                if ($response_nominas >= 1){
                    foreach ($response_nominas as $key => $value) {
                        echo '<tr scope="row">';
                        echo "<td>".$response_nominas[$key]['nombre_nomina']."</td>";
                        echo "<td>$".number_format($response_nominas[$key]['total'])."</td>";
                        if($response_nominas[$key]['estado_nomina'] == 1){
                            echo '<td><span  class="btn btn-warning btn-icon-split btn-sm text-white">
                            <i class="icon fa fa-spinner"></i><span class="label text-padding text-white">&nbsp;&nbsp;Pendiente</span></span></td>';
                        }else if ($response_nominas[$key]['estado_nomina'] == 2) {
                            echo 'td><span  class="btn btn-success btn-icon-split btn-sm text-white">
                            <i class="icon fas fa-check"></i><span class="label text-padding text-white">&nbsp;&nbsp;Aceptado</span></span></td>';
                        }else if($response_nominas[$key]['estado_nomina'] == 3){
                            echo  'td><span  class="btn btn-danger btn-icon-split btn-sm text-white">
                            <i class="icon fas fa-times"></i><span class="label text-padding text-white">&nbsp;&nbsp;Rechazado</span></span></td>';
                        }
                        echo '</tr>';
                    }
                }else{
                    echo '<tr><td></td><td></td><td></td></tr>';
                }
            }
            die();
        }


    }