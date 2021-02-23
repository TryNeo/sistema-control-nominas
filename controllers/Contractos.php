<?php
    require_once ("./libraries/core/controllers.php");

    class Contractos extends Controllers{
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
            getPermisos(6);
        }

        public function contractos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 6;
            $data["tag_pag"] = "Contractos";
            $data["page_title"] = "Contractos | Inicio";
            $data["page_name"] = "Listado de contractos";
            $data['page'] = "contractos";
            $this->views->getView($this,"contractos",$data);
        }


        public function setContracto(){
            if ($_POST) {
                $intContracto = Intval(strclean($_POST['id_contracto']));
                $contractoInput =    strclean($_POST["nombre_contracto"]);
                $descriInput = strclean($_POST["descripcion"]);
                $estadoInput = intval($_POST["estadoInput"]);

                echo $contractoInput;
                echo $descriInput;
                echo $estadoInput;

            }else{
                echo "a";
            }
        }

    }


?>