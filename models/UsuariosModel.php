<?php
    require_once("./libraries/core/mysql.php");
    class UsuariosModel extends Mysql{
        public $int_id_usuario;
        public $str_nombre;
        public $str_apellido;
        public $str_imagen;
        public $str_usuario;
        public $str_email;
        public $int_id_rol;
        public $int_estado;
        public $str_password;


        public function __construct(){
            parent::__construct();
        }

        public function selectUsuarios(){
            $where_admin = "";
            if ($_SESSION['id_usuario'] != 1){
                $where_admin = " and us.id_usuario !=1";
            }
            $sql = "SELECT us.id_usuario,us.nombre,us.apellido,us.foto,us.usuario,us.email,rl.id_rol,rl.nombre_rol,us.estado
             FROM usuarios  as us INNER JOIN roles as rl ON us.id_rol = rl.id_rol WHERE rl.estado !=0 ".$where_admin;
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectUsuario(int $id_usuario){
            $this->int_id_usuario = $id_usuario;
            $sql = "SELECT us.id_usuario,us.nombre,us.apellido,us.foto,us.usuario,us.email,rl.id_rol,us.estado
             FROM usuarios  as us INNER JOIN roles as rl ON us.id_rol = rl.id_rol WHERE us.id_usuario =  $this->int_id_usuario ";
            $request = $this->select_sql($sql);
            return $request;
        }


        public function insertUsuario(string $str_nombre,string $str_apellido,string $str_imagen,
        string $str_usuario,string $str_email,int $int_id_rol,string $str_password, int $int_estado)
        {   
            $return = 0;
            $this->str_nombre = $str_nombre;
            $this->str_apellido = $str_apellido;
            $this->str_imagen = $str_imagen;
            $this->str_usuario = $str_usuario;
            $this->str_email =  $str_email;
            $this->int_id_rol = $int_id_rol;
            $this->str_password = $str_password;
            $this->int_estado = $int_estado;

            $sql = "SELECT * FROM usuarios WHERE usuario = '{$this->str_usuario}' or  email = '{$this->str_email}' ";
            $request = $this->select_sql_all($sql);
            if (empty($request)){
                $sql_insert = "INSERT INTO usuarios (nombre,apellido,foto,usuario,email,id_rol,password,estado,fecha_crea) values (?,?,?,?,?,?,?,?,now())";
                $data = array($this->str_nombre,$this->str_apellido,$this->str_imagen,$this->str_usuario,$this->str_email, $this->int_id_rol,$this->str_password,$this->int_estado);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }
        
        public function updateUsuario(int $int_id_usuario,string $str_nombre,string $str_apellido,
        string $str_imagen,string $str_usuario,string $str_email,int $int_id_rol,string $str_password, int $int_estado){
            $this->int_id_usuario = $int_id_usuario;
            $this->str_nombre = $str_nombre;
            $this->str_apellido = $str_apellido;
            $this->str_imagen = $str_imagen;
            $this->str_usuario = $str_usuario;
            $this->str_email =  $str_email;
            $this->int_id_rol = $int_id_rol;
            $this->str_password = $str_password;
            $this->int_estado = $int_estado;
            
            $sql = "SELECT * FROM usuarios WHERE
                (usuario = '{$this->str_usuario}' and id_usuario =  $this->int_id_usuario  and estado!=0) ";
            
            $request = $this->select_sql($sql);
            
            if (empty($request)){
                if ($this->str_password != "" ) {
                    $sql_update = "UPDATE usuarios SET nombre = ?, apellido = ?,
                    foto = ?,usuario = ?,email = ?, id_rol = ?,password = ?,estado = ? ,fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario  ";
                    $data = array($this->str_nombre,$this->str_apellido,$this->str_imagen,$this->str_usuario,
                    $this->str_email, $this->int_id_rol,$this->str_password,$this->int_estado);
                }else{
                    $sql_update = "UPDATE usuarios SET nombre = ?, apellido = ?,
                    foto = ?,usuario = ?,email = ?,estado = ?,id_rol = ?,fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario  ";
                    $data = array($this->str_nombre,$this->str_apellido,$this->str_imagen,$this->str_usuario,
                    $this->str_email,$this->int_estado,$this->int_id_rol);
                }
                $request = $this->update_sql($sql_update,$data);
            }else{
                $request = "exist";
            }
            return $request;
        }

        
        public function selectImage(int $int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;
            $sql = "SELECT foto FROM usuarios WHERE id_usuario = $this->int_id_usuario" ;
            $request_image = $this->select_sql($sql);
            return $request_image;
        }


        public function selectPassword(int $int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;
            $sql = "SELECT * FROM usuarios WHERE id_usuario = $this->int_id_usuario" ;
            $request_password = $this->select_sql_all($sql);
            return $request_password;
        }


        public function updatePassword(int $int_id_usuario,string $str_password){
            $this->int_id_usuario = $int_id_usuario;
            $this->str_password = $str_password;
            $sql_update = "UPDATE usuarios SET password = ?,fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
            $data = array($this->str_password);
            $request = $this->update_sql($sql_update,$data);
            return $request;
        }

        public function deleteUsuario(int $int_id_usuario){
            $this->int_id_usuario = $int_id_usuario;
            $sql = "UPDATE usuarios SET estado = ?, fecha_modifica = now() WHERE id_usuario = $this->int_id_usuario";
            $data = array(0);
            $request_delete = $this->update_sql($sql,$data);
            return $request_delete;
        }

    }
?>