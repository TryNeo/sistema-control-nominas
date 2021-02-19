<?php
    require_once("./libraries/core/mysql.php");
    class LoginModel extends Mysql{
        public $int_id_usuario;
        public $str_username;
        public $str_password;
        
        public function __construct(){
            parent::__construct();
        }

        public function login_user(string $str_username, string $str_password ){
            $this->str_username = $str_username;
            $this->str_password = $str_password;
            $sql = "SELECT id_usuario,estado FROM usuarios WHERE usuario = '$this->str_username' and password = '$this->str_password'";
            $request = $this->select_sql($sql);
            return $request;
        }        


        public function sessionLogin(int $int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;
            $sql = "SELECT us.id_usuario,us.nombre,us.apellido,us.foto,us.usuario,us.email,r.id_rol,r.nombre_rol,us.estado 
            FROM usuarios us INNER JOIN roles r ON us.id_rol = r.id_rol WHERE us.id_usuario = $this->int_id_usuario";
            $request = $this->select_sql($sql);
            return $request;
        }
    }

?>