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

        public function detalle(int $int_id_nomina){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $intNomina = intval(strclean($int_id_nomina));
            $request_nomina = $this->model->selectNomina($intNomina);
            if (empty($request_nomina)){
                header('location:'.server_url.'nominas');
            }else{

            }            
            
            $data["page_id"] = 8;
            $data["tag_pag"] = "Detalle Nominas";
            $data["page_title"] = "Detalle nominas | Inicio";
            $data["page_name"] = "Detalle de nominas";
            $data["data_nomina"] = $request_nomina;
            $data["page"] = "detalle";
            $this->views->getView($this,"detalle",$data);
        }

        public function getNominas(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectNominas();
                for ($i=0; $i < count($data); $i++) {
                    $btnDetalleNomina = '';
                    $btnEliminarNomina = '';
                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }

                    if ($data[$i]['estado_nomina'] == 1) {
                        $data[$i]['estado_nomina'] = 'Pediente';
                    }else if($data[$i]['estado_nomina'] == 2){
                        $data[$i]['estado_nomina'] = 'Aceptado';
                    }else if($data[$i]['estado_nomina'] == 3){
                        $data[$i]['estado_nomina'] = 'Rechazado';
                    }else{
                        $data[$i]['estado_nomina'] = 'Pediente';
                    }

                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnDetalleNomina = '<a  class="btn btn-primary btn-circle" 
                        title="editar" href="http://localhost/sistema-control-nominas/nominas/detalle/'.$data[$i]['id_nomina'].'"><i class="fas fa-eye"></i></a>';
                    }

                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarNomina = '<button  class="btn btn-danger btn-circle btnEliminarNomina" title="eliminar" nom="'.$data[$i]['id_nomina'].'"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$i]['opciones'] = '<div class="text-center">'.$btnDetalleNomina.' '.$btnEliminarNomina.'</div>';
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getNominaEmpleados(int $int_id_nomina){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $intNomina = intval(strclean($int_id_nomina));
                    $request_get_empl_nomina = $this->model->selectEmpleadosNominas($intNomina);
                    $data = array();
                    for ($i=0; $i < count($request_get_empl_nomina) ; $i++) {
                        $intEmpleado = '';
                        $intEmpleado = $request_get_empl_nomina[$i]['id_empleado'];
                        $data[$i]= $this->model->selectNominaEmpleadoAll($intNomina,$intEmpleado);
                        $data[$i]['id_detalle_nomina'] = '<button  type="button" class="btn btn-danger btn-circle btnEliminarDetalle" 
                        title="eliminar" det="'.$data[$i]['id_detalle_nomina'].'"><i class="far fa-trash-alt"></i></button>';
                    }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
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

        public function setDetalleNomina(){
            if ($_POST) {
                $intEmpleado = Intval(strclean($_POST['id_empleado']));
                $intNomina = Intval(strclean($_POST['id_nomina']));
                $request_insert_detalle = $this->model->insertDetalle($intEmpleado,$intNomina);
                $option =1;
                if ($request_insert_detalle > 0){ 
                    if (empty($_SESSION['permisos_modulo']['w'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                    }else{
                        if ($option == 1){
                            $data = array('status' => true, 'msg' => 'Empleado agregado correctamente');
                        }
                    }
                }else if ($request_insert_detalle == 'exist'){
                    $data = array('status' => false,'msg' => 'Error no puedes añadirlo de nuevo');
                
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

        public function setDetalleGeneral(){
            if (empty($_SESSION['permisos_modulo']['u']) ) {
                header('location:'.server_url.'nominas');
                $data= array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if ($_POST) {
                    $intNomina = intval(strclean($_POST['id_nomina']));
                    $nombre_nomina = strclean($_POST['nombre_nomina']);
                    $meses_nomina = intval(strclean($_POST['meses_detalle']));
                    $estado_nomina = intval(strclean($_POST['estado_nomina']));
                    $total_pagar = floatval(strclean($_POST['total']));
                    $request_sueldo = $this->model->selectDetalleEmpleadosNominas($intNomina);
                    $array_total = array();
                    $array_total_pagar = array();
                    foreach ($request_sueldo as $clave => $valor){
                            $total = 0;
                            $total_new = 0;
                            $total = $meses_nomina*$request_sueldo[$clave]{'sueldo'};
                            array_push($array_total_pagar,$total);
                            array_push($array_total,array('id_nomina'=>$intNomina,
                            'id_empleado' => $request_sueldo[$clave]['id_empleado'],
                            'nombre_nomina' => $nombre_nomina,
                            'meses_nomina' => $meses_nomina,
                            'estado_nomina'=> $estado_nomina,
                            'valor_total' => $total,
                            'total_pagar' => ''));
                        }
                    foreach ($array_total as $clave => $valor) {
                        $update_detalle = $array_total[$clave];
                        $update_detalle['total_pagar'] = array_sum($array_total_pagar);
                        $request_update = $this->model->updateDetalle($update_detalle['id_nomina'],
                        $update_detalle['id_empleado'],$update_detalle['nombre_nomina'],$update_detalle['meses_nomina'],
                        $update_detalle['estado_nomina'],$update_detalle['valor_total'],$update_detalle['total_pagar']);
                    }
                    $data = array('status' => true,'msg' => 'La nomina ha sido generada correctamente');
                }else{
                    $data = array('status' => false,'msg' => 'Errores internos , vuelva intentarlo mas tarde');
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function delDetalleNomina(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if($_POST){
                    $int_id_nomina = intval(strclean($_POST['id_nomina']));
                    $int_id_detalle_nomina = intval(strclean($_POST['id_detalle_nomina']));
                    $request_update_del_one = $this->model->selectNominaTotal($int_id_nomina,$int_id_detalle_nomina);
                    $total = intval($request_update_del_one['valor_total'] - $request_update_del_one['total']);
                    $request_del = $this->model->deleteDetalle($int_id_detalle_nomina);
                    $request_update_nomina = $this->model->updateTotalNomina($int_id_nomina,$total);
                    $data = array("status" => true, "msg" => "Se ha eliminado el detalle");
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
    }

?>