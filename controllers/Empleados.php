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
            $pdf = new reporte();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetTitle('Reporte | Empleados');
            $pdf->renderHeader('W@SECURITY','RUC:0914431192001 | Telefono:XXX-XXX-XXXX','./assets/images/logo-wosecurity.png',13,15,40);
            $pdf->renderText('Listado | Empleados');
            $pdf->SetFont('arial', '', 10);
            $y = $pdf->GetY() + 8;
            
            $pdf->SetXY(10, $y);
            $pdf->MultiCell(8, 8, utf8_decode("Nº"), 1, 'C');
            
            $pdf->SetXY(18, $y); 
            $pdf->MultiCell(22, 8, utf8_decode("Cedula"), 1, 'C');
            
            $pdf->SetXY(40, $y); 
            $pdf->MultiCell(30, 8, utf8_decode("Nombre"), 1, 'C');

            $pdf->SetXY(70, $y); 
            $pdf->MultiCell(30, 8, utf8_decode("Apellido"), 1, 'C');

            $pdf->SetXY(100, $y); 
            $pdf->MultiCell(30, 8, utf8_decode("Telefono"), 1, 'C');

            $pdf->SetXY(130, $y); 
            $pdf->MultiCell(25, 8, utf8_decode("Sueldo"), 1, 'C');

            $pdf->SetXY(155, $y); 
            $pdf->MultiCell(40, 8, utf8_decode("Cargo"), 1, 'C');


            $data = $this->model->selectEmpleadosReporte();
            foreach ($data as $value) {
                $y = $pdf->GetY();
                $pdf->SetXY(10, $y);
                $pdf->MultiCell(8, 8, $value['id_empleado'], 1, 'C');
                $pdf->SetXY(18, $y);
                $pdf->MultiCell(22, 8, $value['cedula'], 1, 'C');
                $pdf->SetXY(40, $y);
                $pdf->MultiCell(30, 8, $value['nombre'], 1, 'C');
                $pdf->SetXY(70, $y);
                $pdf->MultiCell(30, 8, $value['apellido'], 1, 'C');
                $pdf->SetXY(100, $y); 
                $pdf->MultiCell(30, 8, $value['telefono'], 1, 'C');
                $pdf->SetXY(130, $y); 
                $pdf->MultiCell(25, 8, "$".$value['sueldo'], 1, 'C');
                $pdf->SetXY(155, $y); 
                $pdf->MultiCell(40, 8, $value['nombre_puesto'], 1, 'C');                
            }

            $y = $pdf->GetY() + 8;
            $pdf->SetY(120);
            
            $pdf->SetXY(155, $y);
            $pdf->MultiCell(30, 8, utf8_decode("Total Empleados"),1, 'C');
            $pdf->SetXY(185, $y);
            $pdf->MultiCell(10, 8, $this->model->getTotalEmpleado(),1, 'C');

            $y = $pdf->GetY();
            $pdf->SetXY(155, $y);
            $pdf->MultiCell(24, 8, utf8_decode("Total Sueldos"),1, 'C');

            $pdf->SetXY(179, $y);
            $pdf->MultiCell(16, 8,'$'.$this->model->getTotalSueldo()[0]['total'],1, 'C');

            $pdf->Output('', 'reporte_empleados_'.date("d_m_Y_H_i").'.pdf');

        }

        public function setEmpleado(){
            if ($_POST) {
                $int_id_empleado = intval($_POST['id_empleado']);
                $str_nombre = ucwords(strclean($_POST['nombre']));
                $str_apellido = ucwords(strclean($_POST['apellido']));
                $str_cedula = strclean($_POST['cedula']);
                $str_telefono = strclean($_POST['telefono']);
                $float_sueldo = floatval($_POST['sueldo']);
                $int_id_puesto = intval($_POST['id_puesto']);
                $int_id_contracto = intval($_POST['id_contracto']);
                $int_estado = intval(strclean($_POST['estadoInput']));

                if ($int_id_empleado == 0) {
                    $option = 1;
                    $request_empleado = $this->model->insertEmpleado(
                        $str_nombre,
                        $str_apellido,
                        $str_cedula,
                        $str_telefono,
                        $float_sueldo,
                        $int_id_puesto,
                        $int_id_contracto,
                        $int_estado
                    );
                } else {
                    $option = 2;
                    $request_empleado = $this->model->updateEmpleado(
                        $int_id_empleado,
                        $str_nombre,
                        $str_apellido,
                        $str_cedula,
                        $str_telefono,
                        $float_sueldo,
                        $int_id_puesto,
                        $int_id_contracto,
                        $int_estado
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
                $intEmpleado  = Intval(strclean($id_empleado));
                if ($intEmpleado > 0){
                    $data = $this->model->selectEmpleado($intEmpleado);
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

        public function delEmpleado(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data= array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if ($_POST) {
                    $intEmpleado = intval($_POST["id"]);
                    $request_del = $this->model->deleteEmpleado($intEmpleado);
                    if ($request_del == "ok") {
                        $data = array("status" => true, "msg" => "Se ha eliminado el empleado");
                    }else{
                        $data = array("status" => false, "msg" => "Error al eliminar el empleado");
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
    }

?>