<?php
    require_once ("./libraries/core/controllers.php");

    class Empleados extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
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

    }


?>