<?php 
    require_once("./libraries/core/views.php");
    class Controllers{
        public function __construct(){
            $this->views = new Views();
            $this->loadModel();
        }


        public function loadModel(){
            $model = get_class($this)."Model";
            $routeClass = "./models/".$model.".php";
            if (file_exists($routeClass)){
                require_once($routeClass);
                $this->model = new $model();
            }
        }
    }

?>