<?php
    require_once ("./libraries/core/controllers.php");

    class Dashboard extends Controllers{
        public function __construct(){

            parent::__construct();
        }

        public function dashboard($parems){
            $data["page_id"] = 1;
            $data["tag_pag"] = "Dashboard";
            $data["page_title"] = "Dashboard | Inicio";
            $data["page_name"] = "dashboard";
            $data["total_empleados"] = $this->model->getTotalEmpleado();
            $this->views->getView($this,"dashboard",$data);

        }

    }


?>