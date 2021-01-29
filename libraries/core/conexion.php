<?php 
    class Conexion{
        private $conect;

        public function __construct(){
          
        }
        
        public function connect(){
            try{

                $this->conect = new PDO("mysql:dbname=nominas_bd;host=localhost;","tsjosu3","theadmin@lopez");
                $this->conect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $this->conect;
            }
            catch (PDOException $e){
                $this->conect = "Error al conectarse a la base de datos";
                echo "Error".$e->getMessage();
            }
        }
    }
?>