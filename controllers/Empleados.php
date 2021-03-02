<?php
    require_once ("./libraries/core/controllers.php");

    class Empleados extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            session_regenerate_id(true);
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


        public function setEmpleado(){
            if ($_POST) {
                $int_id_empleado = intval($_POST['id_empleado']);
                $str_nombre = ucwords(strclean($_POST['nombre']));
                $str_apellido = ucwords(strclean($_POST['apellido']));
                $str_cedula = strclean($_POST['cedula']);
                $str_email = strclean($_POST['email']);
                $str_telefono = strclean($_POST['telefono']);
                $float_sueldo = floatval($_POST['sueldo']);
                $int_id_contracto = intval($_POST['id_contracto']);
                $int_estado = intval(strclean($_POST['estadoInput']));

                if ($int_id_empleado == 0) {
                    $option = 1;
                    $request_empleado = $this->model->insertEmpleado(
                        $str_nombre,
                        $str_apellido,
                        $str_cedula,
                        $str_email,
                        $str_telefono,
                        $float_sueldo,
                        $int_id_contracto,
                        $int_estado
                    );
                } else {
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


    }


?>