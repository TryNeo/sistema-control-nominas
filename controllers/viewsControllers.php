<?php
    require_once "./models/viewsModels.php";

    class viewsControllers extends viewsModels{
    
        /*-- Controlador para obtener plantilla  --*/
        public function get_template_controller(){
            return require_once "./views/template.php";
        }

        /*-- Controlador para obtener vista-- */
        public function get_views_controller(){
            if (isset($_GET['views'])) { 
                $route = explode("/",$_GET["views"]); //diviendo el string
                $response = viewsModels::get_views_model($route[0]); //obteniendolo
            }else{
                $response = "login"; //caso contrario le pasaremos el login
            }return $response; //retornamos
        }
    
    }

?>