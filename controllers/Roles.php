<?php
    require_once ("./libraries/core/controllers.php");

    class Roles extends Controllers{
        public function __construct(){

            parent::__construct();
        }

        public function roles(){
            $data["page_id"] = 2;
            $data["tag_pag"] = "Roles";
            $data["page_title"] = "Roles | Inicio";
            $data["page_name"] = "Listado de Roles";
            $this->views->getView($this,"roles",$data);

        }

    }


?>