<?php
    require_once ("./libraries/core/controllers.php");

    class Respaldo extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(4);
        }

        public function respaldo(){
            
            $data["tag_pag"] = "Respaldo";
            $data["page_title"] = "Respaldo | Inicio";
            $data["page_name"] = "Respaldo - Base de datos";
            $this->views->getView($this,"respaldo",$data);

        }

    }


?>