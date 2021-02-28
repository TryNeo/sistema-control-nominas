<?php
    require_once ("./libraries/core/controllers.php");

    class Empleados extends Controllers{
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