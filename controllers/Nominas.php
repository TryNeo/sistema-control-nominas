<?php
    require_once ("./libraries/core/controllers.php");
    require_once ("./controllers/Reporte.php");
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

        public function reporteNominas(){
            if (empty($_SESSION['permisos_modulo']['r'])) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                die();
            }else{
                $pdf = new reporte();
                $pdf->AliasNbPages();
                $pdf->AddPage();
                $pdf->SetTitle('Reporte | Nominas');
                $pdf->renderHeader('W@SECURITY','RUC:0914431192001 | Telefono:098-384-9713','./assets/images/logo-wosecurity.png',13,15,40);
                $pdf->renderText('Listado | Nominas');
                $pdf->SetFont('arial', '', 10);
                $y = $pdf->GetY() + 8;
                
                $pdf->SetXY(10, $y);
                $pdf->MultiCell(8, 8, utf8_decode("Nº"), 1, 'C');
                
                $pdf->SetXY(18, $y); 
                $pdf->MultiCell(50, 8, utf8_decode("Nomina"), 1, 'C');
                
                $pdf->SetXY(68, $y); 
                $pdf->MultiCell(26, 8, utf8_decode("Periodo inicio"), 1, 'C');

                $pdf->SetXY(94, $y); 
                $pdf->MultiCell(26, 8, utf8_decode("Periodo fin"), 1, 'C');

                $pdf->SetXY(120, $y); 
                $pdf->MultiCell(38, 8, utf8_decode("Estado nomina"), 1, 'C');

                $pdf->SetXY(158, $y); 
                $pdf->MultiCell(35, 8, utf8_decode("Total"), 1, 'C');

                $cont=0;
                $data = $this->model->selectNominasReporte();
                foreach ($data as $value) {
                    $y = $pdf->GetY();
                    $cont+=1;
                    $pdf->SetXY(10, $y);
                    $pdf->MultiCell(8, 8, $value['id_nomina'], 1, 'C');
                    $pdf->SetXY(18, $y);
                    $pdf->MultiCell(50, 8, $value['nombre_nomina'], 1, 'C');
                    $pdf->SetXY(68, $y);
                    $pdf->MultiCell(26, 8, $value['periodo_inicio'], 1, 'C');
                    $pdf->SetXY(94, $y);
                    $pdf->MultiCell(26, 8, $value['periodo_fin'], 1, 'C');
                    $pdf->SetXY(120, $y); 
                    if($value['estado_nomina'] == 1){
                        $pdf->MultiCell(38, 8,'Pediente', 1, 'C');
                    }else if ($value['estado_nomina'] == 2){
                        $pdf->MultiCell(38, 8,'Aceptado', 1, 'C');
                    }else{
                        $pdf->MultiCell(38, 8,'Rechazado', 1, 'C');
                    }
                    $pdf->SetXY(158, $y); 
                    $pdf->MultiCell(35, 8, "$".number_format($value['total']), 1, 'C');
                    if ($cont == 21){
                        $pdf->AddPage();
                        $pdf->SetTitle('Reporte | Nominas');
                        $pdf->renderHeader('W@SECURITY','RUC:0914431192001 | Telefono:098-384-9713','./assets/images/logo-wosecurity.png',13,15,40);
                        $pdf->renderText('Listado | Nominas');
                        $pdf->SetFont('arial', '', 10);
                        $y = $pdf->GetY() + 8;
                        $pdf->SetXY(2, $y);
                        $cont =1;
                    }
                }

                $y = $pdf->GetY() + 8;
                $pdf->SetY(120);
                
                $pdf->SetXY(120, $y);
                $pdf->MultiCell(38, 8, utf8_decode("Total Nominas"),1, 'C');
                $pdf->SetXY(158, $y);
                $pdf->MultiCell(35, 8, $this->model->getTotalNominas(),1, 'C');

                $y = $pdf->GetY();
                $pdf->SetXY(120, $y);
                $pdf->MultiCell(38, 8, utf8_decode("Total General"),1, 'C');
                $pdf->SetXY(158, $y);
                $pdf->MultiCell(35, 8, '$'.number_format($this->model->getTotalGeneral()[0]['total']),1, 'C');

                
                $pdf->Output('', 'reporte_nominas_'.date("d_m_Y_H_i").'.pdf');
            }
        }

        public function reporteDetalle($id_nomina){
            if (empty($_SESSION['permisos_modulo']['r'])) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                die();
            }else{
                if(empty($id_nomina)){
                    header('location:'.server_url.'nominas');
                }else{
                    $data = $this->model->selectDetalleNomina($id_nomina);
                    if (empty($data)){
                        header('location:'.server_url.'nominas');
                    }else{ 
                        $pdf = new reporte();
                        $pdf->AliasNbPages();
                        $pdf->AddPage();
                        $pdf->SetTitle('Reporte | Detalle Nomina');
                        $pdf->renderHeader('W@SECURITY','RUC:0914431192001 | Telefono:098-384-9713','./assets/images/logo-wosecurity.png',13,15,40);
                        
                        $pdf->SetY(70);
                        $pdf->SetFont('Arial', 'B', 13);
                        $pdf->Cell(0, 15,'Nomina # '.$id_nomina, 0,0,'R');
                        $pdf->SetY(76);
                        $pdf->SetFont('Arial', 'B', 10);
                        $pdf->Cell(0, 15,'Fecha: '.date('d/m/Y'), 0,0,'R');

                        $pdf->SetY(90);
                        $pdf->SetFont('Arial', '', 12);
                        $pdf->Cell(0, 15,'Nomina: '.$data[0]['nombre_nomina'], 0,0,'L');
                        $pdf->SetY(95);
                        $pdf->SetFont('Arial', '', 12);
                        $pdf->Cell(0, 15,'Periodo de Inicio: '.$data[0]['periodo_inicio'], 0,0,'L');
                        $pdf->SetY(100);
                        $pdf->SetFont('Arial', '', 12);
                        $pdf->Cell(0, 15,'Periodo de Fin: '.$data[0]['periodo_fin'], 0,0,'L');
                        if($data[0]['estado_nomina'] == 1){
                            $pdf->SetY(105);
                            $pdf->SetFont('Arial', '', 12);
                            $pdf->Cell(0, 15,'Estado nomina: Pediente', 0,0,'L');
                        }else if ($data[0]['estado_nomina'] == 2){
                            $pdf->SetY(105);
                            $pdf->SetFont('Arial', '', 12);
                            $pdf->Cell(0, 15,'Estado nomina: Aceptado', 0,0,'L');
                        }else{
                            $pdf->SetY(105);
                            $pdf->SetFont('Arial', '', 12);
                            $pdf->Cell(0, 15,'Estado nomina: Rechazado', 0,0,'L');
                        }
                        $pdf->Ln();
                        $pdf->SetFont('arial', 'B', 10);
                        $y = $pdf->GetY() + 8;
                        $cont = 0;
                        $pdf->SetXY(11, $y);
                        $pdf->MultiCell(60, 8, utf8_decode("Empleado"), 1, 'C');
                        $pdf->SetXY(71, $y);
                        $pdf->MultiCell(40, 8, utf8_decode("Cargo"), 1, 'C');
                        $pdf->SetXY(111, $y);
                        $pdf->MultiCell(25, 8, utf8_decode("Sueldo"), 1, 'C');
                        $pdf->SetXY(136, $y);
                        $pdf->MultiCell(25, 8, utf8_decode("Meses"), 1, 'C');
                        $pdf->SetXY(161, $y);
                        $pdf->MultiCell(30, 8, utf8_decode("Total"), 1, 'C');
                        foreach ($data[1] as $value) {
                            $pdf->SetFont('arial', '', 10);
                            $y = $pdf->GetY();
                            $cont+=1;
                            $pdf->SetXY(11, $y);
                            $pdf->MultiCell(60, 8, $value['nombre']." ".$value['apellido'], 1, 'C');
                            $pdf->SetXY(71, $y);
                            $pdf->MultiCell(40, 8, $value['nombre_puesto'], 1, 'C');
                            $pdf->SetXY(111, $y);
                            $pdf->MultiCell(25, 8, "$".number_format($value['sueldo']), 1, 'C');
                            $pdf->SetXY(136, $y);
                            $pdf->MultiCell(25, 8, $value['meses'], 1, 'C');
                            $pdf->SetXY(161, $y);
                            $pdf->MultiCell(30, 8, "$".number_format($value['valor_total']), 1, 'C');
                            if ($cont == 21){
                                $pdf->AddPage();
                                $pdf->SetTitle('Reporte | Detalle Nomina');
                                $pdf->renderHeader('W@SECURITY','RUC:0914431192001 | Telefono:098-384-9713','./assets/images/logo-wosecurity.png',13,15,40);
                                $y = $pdf->GetY() + 8;
                                $pdf->SetXY(2, $y);
                                $cont =1;
                            }
                        }

                        $y = $pdf->GetY() + 8;
                        $pdf->SetY(120);
                        
                        $pdf->SetXY(136, $y);
                        $pdf->MultiCell(25, 8, utf8_decode("Total a pagar"),1, 'C');
                        $pdf->SetXY(161, $y);
                        $pdf->MultiCell(30, 8, "$".number_format($data[0]['total']),1, 'C');
                        $pdf->Output('', 'reporte_detalle_nominas_'.date("d_m_Y_H_i").'.pdf');

                    }

                }

            }

        }

        public function getNominas(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectNominas();
                foreach($data  as $clave => $valor){
                    $btnDetalleNomina = '';
                    $btnReporteDetalle = '';
                    $btnEliminarNomina = '';
                    $data[$clave]['estado'] = ($data[$clave]['estado'] == 1) ? '<span  class="btn btn-success btn-icon-split btn-sm">
                        <i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>': 
                        '<span  class="btn btn-danger btn-icon-split btn-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    
                    $data[$clave]['total'] = "<strong>"."$".number_format($data[$clave]['total'])."</strong>";

                    if ($data[$clave]['estado_nomina'] == 1) {
                        $data[$clave]['estado_nomina'] = '<span  class="btn btn-warning btn-icon-split btn-sm text-white">
                        <i class="icon fa fa-spinner"></i><span class="label text-padding text-white">&nbsp;&nbsp;Pendiente</span></span>';
                    }else if($data[$clave]['estado_nomina'] == 2){
                        $data[$clave]['estado_nomina'] = '<span  class="btn btn-success btn-icon-split btn-sm text-white">
                        <i class="icon fas fa-check"></i><span class="label text-padding text-white">&nbsp;&nbsp;Aceptado</span></span>';
                    }else if($data[$clave]['estado_nomina'] == 3){
                        $data[$clave]['estado_nomina'] = '<span  class="btn btn-danger btn-icon-split btn-sm text-white">
                        <i class="icon fas fa-times"></i><span class="label text-padding text-white">&nbsp;&nbsp;Rechazado</span></span>';
                    }

                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnDetalleNomina = '<a  class="btn btn-primary btn-circle" 
                        title="nomina" href="'.server_url."nominas/detalle/".$data[$clave]['id_nomina'].'"><i class="fas fa-eye"></i></a>';
                    }

                    if ($_SESSION['permisos_modulo']['r']) {
                        $btnReporteDetalle = '<button  class="btn btn-dark btn-circle" 
                        title="nomina" onclick="return abrir_modal_reporte_detalle('.$data[$clave]['id_nomina'].')"><i class="fas fa-print"></i></button>';
                    }


                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarNomina = '<button  class="btn btn-danger btn-circle btnEliminarNomina" title="eliminar" nom="'.$data[$clave]['id_nomina'].'"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$clave]['opciones'] = '<div class="text-center">'.$btnDetalleNomina.' '.$btnReporteDetalle.' '.$btnEliminarNomina.'</div>';
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function detalle(int $int_id_nomina){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }else{
                $id_nomina = intval(strclean($int_id_nomina));
                $request_nomina = $this->model->selectNomina($id_nomina);
                if (empty($request_nomina)){
                    header('location:'.server_url.'nominas');
                }else{
                    $data["page_id"] = 8;
                    $data["tag_pag"] = "Detalle Nominas";
                    $data["page_title"] = "Detalle nominas | Inicio";
                    $data["page_name"] = "Detalle de nominas";
                    $data["data_nomina"] = $request_nomina;
                    $data["page"] = "detalle";
                    $this->views->getView($this,"detalle",$data);
                }
            }
        }

        public function estado(){
            if (empty($_SESSION['permisos'][9]['r']) ) {
                header('location:'.server_url.'Errors');
            }else{
                $data["page_id"] = 9;
                $data["tag_pag"] = "Estado de nomina";
                $data["page_title"] = "Estado de nominas | Inicio";
                $data["page_name"] = "Estado de nominas";
                $data["page"] = "estado";
                $this->views->getView($this,"estado",$data);
            }   
        }

        public function getEstadoNominas(){
            if (empty($_SESSION['permisos'][9]['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectEstadoNominas();
                foreach($data  as $clave => $valor){
                    $btnAceptarNomina = '';
                    $btnRechazarNomina = '';
                    $data[$clave]['total'] = "<strong>"."$".number_format($data[$clave]['total'])."</strong>";
                    
                    if ($_SESSION['permisos'][9]['u']) {
                        if($data[$clave]['estado_nomina'] == 3 || $data[$clave]['estado_nomina'] == 2){
                            $btnAceptarNomina = '<button disabled class="btn btn-success btn-circle btnAceptarNomina" 
                            title="Aceptar nomina" nom="'.$data[$clave]['id_nomina'].'"  acept="2"><i class="fas fa-check"></i></button>';   
                        }else{
                            $btnAceptarNomina =  '<button  class="btn btn-success btn-circle btnAceptarNomina" 
                            title="Aceptar nomina" nom="'.$data[$clave]['id_nomina'].'"  acept="2"><i class="fas fa-check"></i></button>';                            
                        }
                    }  

                    if ($_SESSION['permisos'][9]['d']) {
                        if($data[$clave]['estado_nomina'] == 3 || $data[$clave]['estado_nomina'] == 2 ){
                            $btnRechazarNomina  = '<button  disabled class="btn btn-danger btn-circle btnRechazarNomina" 
                            title="Rechazar nomina" nom="'.$data[$clave]['id_nomina'].'"  rech="3"><i class="fas fa-times"></i></button>';
                        }else{
                            $btnRechazarNomina  = '<button  class="btn btn-danger btn-circle btnRechazarNomina" 
                            title="Rechazar nomina" nom="'.$data[$clave]['id_nomina'].'"  rech="3"><i class="fas fa-times"></i></button>';
                        }
                    }

                    if ($data[$clave]['estado_nomina'] == 1) {
                        $data[$clave]['estado_nomina'] = '<span  class="btn btn-warning btn-icon-split btn-sm text-white">
                        <i class="icon fa fa-spinner"></i><span class="label text-padding text-white">&nbsp;&nbsp;Pendiente</span></span>';
                    }else if($data[$clave]['estado_nomina'] == 2){
                        $data[$clave]['estado_nomina'] = '<span  class="btn btn-success btn-icon-split btn-sm text-white">
                        <i class="icon fas fa-check"></i><span class="label text-padding text-white">&nbsp;&nbsp;Aceptado</span></span>';
                    }else if($data[$clave]['estado_nomina'] == 3){
                        $data[$clave]['estado_nomina'] = '<span  class="btn btn-danger btn-icon-split btn-sm text-white">
                        <i class="icon fas fa-times"></i><span class="label text-padding text-white">&nbsp;&nbsp;Rechazado</span></span>';
                    }

                    $data[$clave]['opciones'] = '<div class="text-center">'.$btnAceptarNomina.' '.$btnRechazarNomina.'</div>';
                };
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setEstadoNominas(){
            if ($_POST) {
                $id_nomina = intVal(strclean($_POST['id_nomina']));
                $estado_nomina = intVal(strclean($_POST['estado']));
                if(validateEmptyFields([$id_nomina,$estado_nomina])){
                    if(empty(preg_matchall([$id_nomina,$estado_nomina],regex_numbers))){
                        if($estado_nomina == 2 || $estado_nomina == 3){
                            if ($estado_nomina == 2){
                                $response_estado_nomina = $this->model->updateEstadoNomina($id_nomina,$estado_nomina);
                                $option = 1;
                            }

                            if ($estado_nomina == 3){
                                $response_estado_nomina = $this->model->updateEstadoNomina($id_nomina,$estado_nomina);
                                $option = 2;
                            }

                            if($response_estado_nomina  > 0 ){
                                if($option == 1){
                                    $data = array('status' => true, 'msg' => 'Nomina aceptada correctamente');
                                }

                                if($option == 2){
                                    $data = array('status' => true, 'msg' => 'Nomina rechazada correctamente');
                                }

                            }else if ($response_estado_nomina == 'no'){
                                $data = array('status' => false,'msg' => 'Error de datos no existe tal nomina ,verifique que todo se encuentre bien');
                            }else{
                                $data = array('status' => false,'msg' => 'Oops hubo error ,verifique que todo se encuentre bien');
                            }
                        }else{
                            $data = array('status' => false,'msg' => 'Error de datos ,verifique que todo se encuentre bien');
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
                        $data[$i]['sueldo'] = $data[$i]['sueldo'];
                        $data[$i]['valor_total'] = $data[$i]['valor_total'];

                        $data[$i]['id_detalle_nomina'] = '<button  type="button" class="btn btn-danger btn-circle btnEliminarDetalle" 
                        title="eliminar" det="'.$data[$i]['id_detalle_nomina'].'"><i class="far fa-trash-alt"></i></button>';
                    }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
        
        public function setNomina(){
            if ($_POST) {
                $id_nomina = intval(strclean($_POST['id_nomina']));
                $nombre_nomina = ucwords(strtolower(strclean($_POST['nombre_nomina'])));
                $periodo_inicio = strclean($_POST['periodo_inicio']);
                $periodo_fin = strclean($_POST['periodo_fin']);
                $estado_nomina = intval(strclean($_POST['estado_nomina']));
                $estado = intval(strclean($_POST['estadoInput']));
                $validate_data = [$nombre_nomina,$periodo_inicio,$periodo_fin,$estado_nomina,$estado];
                if(validateEmptyFields($validate_data)){
                    if(empty(preg_matchall([$nombre_nomina],regex_string)) && 
                        empty(preg_matchall([$estado,$estado_nomina],regex_numbers))){
                            if($id_nomina == 0){
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
        
        public function setDetalleMesesTotal(){
            if (empty($_SESSION['permisos_modulo']['u']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $id_detalle_nomina = strclean($_POST['id_detalle_nomina']);
                $meses = Intval(strclean($_POST['meses']));
                $total = Intval(strclean($_POST['total']));
                $response_data = $this->model->updateDetalleMesesTotal($id_detalle_nomina,$meses,$total);
                if($response_data =="ok"){
                    $data = array('status' => true,'msg' => 'todo correctamente');
                }else{
                    $data = array('status' => false,'msg' => 'Hubo un error en la base de datos');
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getNominaEmpleado(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if(empty($_POST)){
                    $request_data = $this->model->selectNominaEmpleado('');
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_empleado'], "text"=>$row['nombre'],
                        "apellido" => $row['apellido'],"sueldo" => $row['sueldo'],"puesto" => $row['nombre_puesto']);
                    }
                }else{
                    $search_empleado = strclean($_POST['search']);
                    $request_data = $this->model->selectNominaEmpleado($search_empleado);
                    foreach ($request_data as $row) {    
                        $data[] = array("id"=>$row['id_empleado'], "text"=>$row['nombre'],
                        "apellido" => $row['apellido'],"sueldo" => $row['sueldo'],"puesto" => $row['nombre_puesto']);
                    }
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
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
                    $nombre_nomina = ucwords(strtolower(strclean($_POST['nombre_nomina'])));
                    $estado_nomina = intval(strclean($_POST['estado_nomina']));
                    $total_pagar = floatval(strclean($_POST['total']));
                    $request_sueldo = $this->model->selectDetalleEmpleadosNominas($intNomina);
                    $array_total = array();
                    foreach ($request_sueldo as $clave => $valor){
                            $total = 0;
                            $total_new = 0;
                            array_push($array_total,array('id_nomina'=>$intNomina,
                            'id_empleado' => $request_sueldo[$clave]['id_empleado'],
                            'nombre_nomina' => $nombre_nomina,
                            'estado_nomina'=> $estado_nomina,
                            'total_pagar' => $total_pagar));
                        }

                        foreach ($array_total as $clave => $valor) {
                        $update_detalle = $array_total[$clave];
                        $request_update = $this->model->updateDetalle($update_detalle['id_nomina'],
                            $update_detalle['id_empleado'],$update_detalle['nombre_nomina'],
                            $update_detalle['estado_nomina'],$update_detalle['total_pagar']);
                    }
                    $data = array('status' => true,'msg' => 'La nomina ha sido generada correctamente');
                }else{
                    $data = array('status' => false,'msg' => 'Errores internos , vuelva intentarlo mas tarde');
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
        
        public function delDetalleEmpleado(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if($_POST){
                    $int_id_nomina = intval(strclean($_POST['id_nomina']));
                    $int_id_detalle_nomina = intval(strclean($_POST['id_detalle_nomina']));
                    $del_detalle_empl = $this->model->deleteDetalle($int_id_detalle_nomina);
                    if ($del_detalle_empl == "ok"){
                        $up_nomina_total = $this->model->selectNominaTotal($int_id_nomina);
                        if(empty($up_nomina_total)){
                            $data = array("status" => false, "msg" => "El empleado no existe");
                        }else{
                            $total = ($up_nomina_total['total'] == '') ? 0 : $up_nomina_total['total'];
                            $up_nomina_total = $this->model->updateNominaTotal($int_id_nomina,$total);
                            if($up_nomina_total == 'ok'){
                                $data = array("status" => true, "msg" => "El empleado ha sido eliminado correctamente");
                            }else{
                                $data = array("status" => false, "msg" => "Error hubo problemas al actualizar el total de la nomina");
                            }
                        }
                    }else{
                        $data = array("status" => false, "msg" => "Error hubo problemas al eliminar el empleado");
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        
        public function delNomina(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if($_POST){
                    $int_id_nomina = intval($_POST["id"]);
                    $request_del = $this->model->deleteNomina($int_id_nomina);
                    if($request_del == "ok"){
                        $data = array("status" => true, "msg" => "Se ha eliminado la nomina");
                    }else{
                        $data = array("status" => false, "msg" => "Error al eliminar la nomina");
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
        
    }
