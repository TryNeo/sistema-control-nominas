<?php
    require_once("./libraries/core/mysql.php");
    class UsuariosModel extends Mysql{
        public $int_id_usuario;
        public $str_nombre;
        public $str_apellido;
        public $str_usuario;
        public $str_email;
        public $int_id_rol;
        public $int_estado;
        public $str_password;


        public function __construct(){
            parent::__construct();
        }

        public function selectUsuarios(){
            $sql = "SELECT id_usuario,nombre,apellido,usuario,email,id_rol,estado FROM usuarios";
            $request = $this->select_sql_all($sql);
            return $request;
        }


        public function insertUsuario(string $str_nombre,string $str_apellido,string $str_usuario,string $str_email,int $int_id_rol,string $str_password, int $int_estado)
        {   
            $return = 0;
            $this->str_nombre = $str_nombre;
            $this->str_apellido = $str_apellido;
            $this->str_usuario = $str_usuario;
            $this->str_email =  $str_email;
            $this->int_id_rol = $int_id_rol;
            $this->str_password = $str_password;
            $this->int_estado = $int_estado;

            $sql = "SELECT * FROM usuarios WHERE usuario = '{$this->str_usuario}' or  email = '{$this->str_email}' ";
            $request = $this->select_sql_all($sql);
            if (empty($request)){
                $sql_insert = "INSERT INTO usuarios (nombre,apellido,usuario,email,id_rol,password,estado,fecha_crea) values (?,?,?,?,?,?,?,now())";
                $data = array($this->str_nombre,$this->str_apellido,$this->str_usuario,$this->str_email, $this->int_id_rol,$this->str_password,$this->int_estado);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }
        

      


    }
?>