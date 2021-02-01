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
            $sql = "SELECT id_rol,nombre,descripcion,estado FROM roles";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectRol(int $id_rol){
            $this->intRol = $id_rol;
            $sql = "SELECT id_rol,nombre,descripcion,estado FROM roles where id_rol =$this->intRol";
            $request = $this->select_sql($sql);
            return $request;

        }

        public function insertRol(string $rolInput,string $descriInput, int $estadoInput)
        {   
            $return = "";
            $this->strRol = $rolInput;
            $this->strDescrip = $descriInput;
            $this->intEstado = $estadoInput;
            $sql = "SELECT * FROM roles WHERE nombre = '{$this->strRol}'";
            $request = $this->select_sql_all($sql);
            if (empty($request)){
                $sql_insert = "INSERT INTO roles(nombre,descripcion,estado,fecha_crea) values (?,?,?,now())";
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
            
            $sql = "SELECT * FROM roles WHERE nombre = '$this->strRol' and  id_rol =  $this->intRol ";
            $request_update= $this->select_sql_all($sql);

            if (empty($request_update)){
                $sql_udpate = "UPDATE roles SET nombre = ?, descripcion = ?, estado = ?,fecha_modifica = now()  WHERE id_rol = $this->intRol";
                $data = array($this->strRol,$this->strDescrip,$this->intEstado);
                $request_update = $this->update_sql($sql_udpate,$data);
            }else{
                $request_update= "exist";
            }
            return $request_update;
        }
    }
    

?>