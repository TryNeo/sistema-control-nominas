<?php
    require_once("./libraries/core/mysql.php");
    class RolesModel extends Mysql{
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
        
    }
    

?>