<?php
    require_once("./libraries/core/mysql.php");
    class ContractosModel extends Mysql{
        public $int_id_contracto;
        public $str_contracto;
        public $str_descripcion;
        public $intEstado;

        public function __construct(){
            parent::__construct();
        }


        public function selectContractos(){
            $sql = "SELECT id_contracto,nombre_contracto,descripcion,estado FROM contractos";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function insertContracto(string $contractoInput, string $descriInput, int $estadoInput){
            $return = "";
            $this->str_contracto =  $contractoInput;
            $this->str_descripcion = $descriInput;
            $this->intEstado = $estadoInput;
            $sql = "SELECT * FROM contractos WHERE nombre_contracto = '{$this->str_contracto}'";
            $request = $this->select_sql_all($sql);
            if (empty($request)){
                $sql_insert = "INSERT INTO contractos(nombre_contracto,descripcion,estado,fecha_crea) values (?,?,?,now())";
                $data = array($this->str_contracto,$this->str_descripcion,$this->intEstado);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }
    }
?>