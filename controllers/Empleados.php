<?php
    require_once ("./libraries/core/controllers.php");
    require_once ("./controllers/Reporte.php");
    class Empleados extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(5);
        }

        public function empleados(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 5;
            $data["tag_pag"] = "Empleados";
            $data["page_title"] = "Empleados | Inicio";
            $data["page_name"] = "Listado de empleados";
            $data['page'] = "empleados";
            $this->views->getView($this,"empleados",$data);
        }

        public function reporteEmpleados(){
            if (empty($_SESSION['permisos_modulo']['r'])) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                die();
            }else{
                $pdf = new reporte();
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetTitle('Reporte | Empleados');
                $pdf->renderHeader('W@SECURITY','RUC:0914431192001 | Telefono:098-384-9713','./assets/images/logo-wosecurity.png',13,15,40);
                $pdf->renderText('Listado | Empleados');
                $pdf->SetFont('arial', '', 10);
                $y = $pdf->GetY() + 8;
                
                $pdf->SetXY(10, $y);
                $pdf->MultiCell(8, 8, utf8_decode("Nº"), 1, 'C');
                
                $pdf->SetXY(18, $y); 
                $pdf->MultiCell(22, 8, utf8_decode("Cedula"), 1, 'C');
                
                $pdf->SetXY(40, $y); 
                $pdf->MultiCell(40, 8, utf8_decode("Nombre"), 1, 'C');
    
                $pdf->SetXY(80, $y); 
                $pdf->MultiCell(40, 8, utf8_decode("Apellido"), 1, 'C');
    
                $pdf->SetXY(120, $y); 
                $pdf->MultiCell(27, 8, utf8_decode("Telefono"), 1, 'C');
    
                $pdf->SetXY(147, $y); 
                $pdf->MultiCell(25, 8, utf8_decode("Sueldo"), 1, 'C');
    
                $pdf->SetXY(172, $y); 
                $pdf->MultiCell(30, 8, utf8_decode("Cargo"), 1, 'C');
    
                $cont = 0;
                $data = $this->model->selectEmpleadosReporte();
                foreach ($data as $value) {
                    $y = $pdf->GetY();
                    $cont+=1;
                    $pdf->SetXY(10, $y);
                    $pdf->MultiCell(8, 8, utf8_decode($value['id_empleado']), 1, 'C');
                    $pdf->SetXY(18, $y);
                    $pdf->MultiCell(22, 8, utf8_decode($value['cedula']), 1, 'C');
                    $pdf->SetXY(40, $y);
                    $pdf->MultiCell(40, 8, utf8_decode($value['nombre']), 1, 'C');
                    $pdf->SetXY(80, $y);
                    $pdf->MultiCell(40, 8, utf8_decode($value['apellido']), 1, 'C');
                    $pdf->SetXY(120, $y); 
                    $pdf->MultiCell(27, 8, utf8_decode($value['telefono']), 1, 'C');
                    $pdf->SetXY(147, $y); 
                    $pdf->MultiCell(25, 8, utf8_decode("$".$value['sueldo']), 1, 'C');
                    $pdf->SetXY(172, $y); 
                    $pdf->MultiCell(30, 8, utf8_decode($value['nombre_puesto']), 1, 'C');
                    if ($cont == 21){
                        $pdf->AddPage();
                        $pdf->SetTitle('Reporte | Empleados');
                        $pdf->renderHeader('W@SECURITY','RUC:0914431192001 | Telefono:098-384-9713','./assets/images/logo-wosecurity.png',13,15,40);
                        $pdf->renderText('Listado | Empleados');
                        $pdf->SetFont('arial', '', 10);
                        $y = $pdf->GetY() + 8;
                        $pdf->SetXY(2, $y);
                        $cont =1;
                    }
                }
                $y = $pdf->GetY() + 8;$pdf->SetY(120);$pdf->SetXY(142, $y);$pdf->MultiCell(30, 8, utf8_decode("Total Empleados"),1, 'C');
                $pdf->SetXY(172, $y);$pdf->MultiCell(30, 8,$this->model->getTotalEmpleado(),1, 'C');
                $y = $pdf->GetY();$pdf->SetXY(142, $y);$pdf->MultiCell(30, 8, utf8_decode("Total Sueldos"),1, 'C');
                $pdf->SetXY(172, $y);$pdf->MultiCell(30, 8,'$'.number_format($this->model->getTotalSueldo()[0]['total']),1, 'C');
    
                $pdf->Output('', 'reporte_empleados_'.date("d_m_Y_H_i").'.pdf');

            }
        }

        public function setEmpleado(){
            if ($_POST) {
                $id_empleado = intval($_POST['id_empleado']);
                $nombre_empleado = ucwords(strtolower(strclean($_POST['nombre'])));
                $apellido_empleado = ucwords(strtolower(strclean($_POST['apellido'])));
                $cedula_empleado = strclean($_POST['cedula']);
                $telefono_empleado = strclean($_POST['telefono']);
                $sueldo_empleado = floatval($_POST['sueldo']);
                $id_puesto_empleado = intval($_POST['id_puesto']);
                $id_contrato_empleado = intval($_POST['id_contrato']);
                $estado_empleado = intval(strclean($_POST['estadoInput']));
                $validate_data = array($nombre_empleado,$apellido_empleado,
                                $cedula_empleado,$telefono_empleado,$sueldo_empleado,
                                $id_puesto_empleado,$id_contrato_empleado,$estado_empleado);
                $validate_data_regex = array($nombre_empleado,$apellido_empleado);
                $validate_data_regex_numbers = array($cedula_empleado,$sueldo_empleado,$id_puesto_empleado,$id_contrato_empleado,$estado_empleado);
                if(validateEmptyFields($validate_data)){
                    if(empty(preg_matchall($validate_data_regex,regex_string)) && empty(preg_matchall($validate_data_regex_numbers,regex_numbers))){
                        if(validateCedula($cedula_empleado,regex_cedula)){
                            if ($id_empleado == 0) {
                                $option = 1;
                                $request_empleado = $this->model->insertEmpleado(
                                    $nombre_empleado,
                                    $apellido_empleado,
                                    $cedula_empleado,
                                    $telefono_empleado,
                                    $sueldo_empleado,
                                    $id_puesto_empleado,
                                    $id_contrato_empleado,
                                    $estado_empleado
                                );
                            } else {
                                $option = 2;
                                $request_empleado = $this->model->updateEmpleado(
                                    $id_empleado,
                                    $nombre_empleado,
                                    $apellido_empleado,
                                    $cedula_empleado,
                                    $telefono_empleado,
                                    $sueldo_empleado,
                                    $id_puesto_empleado,
                                    $id_contrato_empleado,
                                    $estado_empleado
                                );
                            }
            
                            if ($request_empleado > 0) {
                                if (empty($_SESSION['permisos_modulo']['w'])){
                                    header('location:'.server_url.'Errors');
                                    $data= array("status" => false, "msg" => "Error no tiene permisos");
                                }else{
                                    if ($option == 1){
                                        $data = array('status' => true, 'msg' => 'datos guardados correctamente');
                                    }
                                }
            
            
                                if (empty($_SESSION['permisos_modulo']['u'])) {
                                    header('location:'.server_url.'Errors');
                                    $data= array("status" => false, "msg" => "Error no tiene permisos");
                                }else{
                                    if ($option == 2){
                                        $data = array('status' => true, 'msg' => 'datos actualizados correctamente');
                                    }
                                }
            
                            }else if ($request_empleado == 'exist'){
                                $data = array('status' => false, 'msg' => 'Error datos ya existentes');
                            }else{
                                $data = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                            }
                        }else{
                            $data = array('status' => false, 'msg' => 'La cedula ingresada es valida, verifique y vuelva a ingresarlos');
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
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getEmpleados(){
            if (empty($_SESSION['permisos_modulo']['r'])) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectEmpleados();
                for ($i=0; $i < count($data); $i++) { 
                    $btnEditarEmpleado = '';
                    $btnEliminarEmpleado = '';
                
                    $data[$i]['sueldo'] = "$".number_format($data[$i]['sueldo']);
                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }

                    
                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarEmpleado = '<button  class="btn btn-primary btn-circle btnEditarEmpleado"  title="editar" emp="'.$data[$i]['id_empleado'].'"><i class="fa fa-edit"></i></button>';
                    }

                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarEmpleado = '<button  class="btn btn-danger btn-circle btnEliminarEmpleado"  title="eliminar" emp="'.$data[$i]['id_empleado'].'"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$i]['opciones'] = '<div class="text-center">'.$btnEditarEmpleado.' '.$btnEliminarEmpleado.'</div>';
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getEmpleado(int $id_empleado){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $id_empleado  = Intval(strclean($id_empleado));
                if(empty(preg_matchall([$id_empleado],regex_numbers))){
                    if ($id_empleado > 0){
                        $data = $this->model->selectEmpleado($id_empleado);
                        if (empty($data)){
                            $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                        }else{
                            $data_response = array('status' => true,'msg'=> $data);
                        }
                    }
                }else{
                    $data_response = array('status' => false,'msg' => 'Oops!, El campo no es valido, verifiquelo y vuelva a intentarlo');
                }
            }
            echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function delEmpleado(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data= array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if ($_POST) {
                    $id_empleado = intval(strclean($_POST["id"]));
                    $validate_data = array($id_empleado);
                    if (validateEmptyFields($validate_data)){
                        if (empty(preg_matchall($validate_data,regex_numbers))) {
                            $request_del = $this->model->deleteEmpleado($id_empleado);
                            if ($request_del == "ok") {
                                $data = array("status" => true, "msg" => "Se ha eliminado el empleado");
                            }else{
                                $data = array("status" => false, "msg" => "Error al eliminar el empleado");
                            }
                        }else{
                            $data = array('status' => false,'msg' => 'Oops!, El campo no es valido');
                        }
                    }else{
                        $data = array("status" => false, "msg" => "Oops!, no existe tal contrato o estas mandado datos erroneos");
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
