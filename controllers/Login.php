<?php
    require_once ("./libraries/core/controllers.php");

    class Login extends Controllers{
        public function __construct(){

            parent::__construct();
        }

        public function login(){
            $data["page_id"] = 4;
            $data["tag_pag"] = "Login";
            $data["page_title"] = "Login | Iniciar secion";
            $data["page_name"] = "login";
            $this->views->getView($this,"login",$data);

        }

    }


?>