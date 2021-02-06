<?php
    require_once ("./libraries/core/controllers.php");

    class Usuarios extends Controllers{
        public function __construct(){

            parent::__construct();
        }

        public function usuarios($parems){
            $data["tag_pag"] = "Usuarios";
            $data["page_title"] = "Usuarios| Inicio";
            $data["page_name"] = "Listado de usuarios";
            $this->views->getView($this,"usuarios",$data);

        }



    }


?>