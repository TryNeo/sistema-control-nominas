<?php
    require_once ("./libraries/core/controllers.php");

    class Dashboard extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            session_regenerate_id(true);
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
            $data["total_empleados"] = 0;
            $this->views->getView($this,"dashboard",$data);

        }

    }


?>