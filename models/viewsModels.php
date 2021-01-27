<?php 
    /*-- Modelo para obtener vistas --*/
    class viewsModels{
        protected static function get_views_model($views){
            $listWhite = ["dashboard"]; // palabras permitidas dentro del sistema
            if(in_array($views,$listWhite)){ // comprobando existencia en la lista con in_array()
                if(is_file("./views/contents/".$views."-view.php")){ //comprobamos existencia y le pasaremos el $view
                    $content = "./views/contents/".$views."-view.php"; //lo colocamos en una variable 
                }else{
                    $content = "404";
                }
            }elseif($views=="login" || $views == "index"){
                $content = "login";
            }else{
                $content = "404";
            }
            return $content; //retornamos
        }
    }
?>