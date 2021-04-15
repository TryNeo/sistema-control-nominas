<?php
    require_once("./libraries/core/mysql.php");
    class RolesModel extends Mysql{
        public $intRol;
        public $strRol;
        public $strDescrip;
        public $intEstado;
        public $strFechaCrea;

        public function __construct(){
            parent::__construct();
        }

        public function selectRoles(){
            $sql = "SELECT id_rol,nombre_rol,descripcion,estado FROM roles";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectRolesNoInactivos(){
            $where_admin = "";
            if($_SESSION['id_usuario'] != 1){
                $where_admin = " and id_rol !=1";
            }
            $sql = "SELECT id_rol,nombre_rol,descripcion,estado FROM roles WHERE estado!=0 ".$where_admin;
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectRol(int $id_rol){
            $this->intRol = $id_rol;
            $sql = "SELECT id_rol,nombre_rol,descripcion,estado FROM roles where id_rol =$this->intRol";
            $request = $this->select_sql($sql);
            return $request;

        }

        public function insertRol(string $rolInput,string $descriInput, int $estadoInput)
        {   
            $return = "";
            $this->strRol = $rolInput;
            $this->strDescrip = $descriInput;
            $this->intEstado = $estadoInput;
            $sql = "SELECT * FROM roles WHERE nombre_rol = '{$this->strRol}'";
            $request = $this->select_sql_all($sql);
            if (empty($request)){
                $sql_insert = "INSERT INTO roles(nombre_rol,descripcion,estado,fecha_crea) values (?,?,?,now())";
                $data = array($this->strRol,$this->strDescrip,$this->intEstado);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }
        

        public function updateRol(int $intRol,string $rolInput,string $descriInput, int $estadoInput)
        {   
            $this->intRol = $intRol;
            $this->strRol = $rolInput;
            $this->strDescrip = $descriInput;
            $this->intEstado = $estadoInput;
            
            $sql = "SELECT * FROM roles WHERE nombre_rol = '$this->strRol' and  id_rol =  $this->intRol and estado !=0";
            $request_update= $this->select_sql_all($sql);   

            if (empty($request_update)){
                $sql_udpate = "UPDATE roles SET nombre_rol = ?, descripcion = ?, estado = ?,fecha_modifica = now()  WHERE id_rol = $this->intRol";
                $data = array($this->strRol,$this->strDescrip,$this->intEstado);
                $request_update = $this->update_sql($sql_udpate,$data);
            }else{
                $request_update= "exist";
            }
            return $request_update;
        }


        public function deleteRol(int $intRol){
            $this->intRol = $intRol;
            $sql = "SELECT * FROM usuarios WHERE id_rol = $this->intRol";
            $request_delete = $this->select_sql_all($sql);
            if(empty($request_delete)){
                $sql = "UPDATE roles set estado = ? , fecha_modifica = now() WHERE id_rol = $this->intRol";
                $data = array(0);
                $request_delete = $this->update_sql($sql,$data);
                if ($request_delete){
                    $request_delete = 'ok';
                }else{
                    $request_delete = 'error';
                }
            }else{
                $request_delete = 'exist';
            }
            return $request_delete;
        }
    }
?>