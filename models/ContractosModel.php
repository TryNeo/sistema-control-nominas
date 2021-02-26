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

        public function selectContractosNoInactivos(){
            $sql = "SELECT id_contracto,nombre_contracto,descripcion,estado FROM contractos WHERE estado!=0";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectContracto(int $id_contracto){
            $this->int_id_contracto = $id_contracto;
            $sql = "SELECT id_contracto,nombre_contracto,descripcion,estado FROM contractos WHERE id_contracto = $this->int_id_contracto";
            $request = $this->select_sql($sql);
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

        public function updateContracto(int $intContracto,string $contractoInput,string $descriInput,int $estadoInput){
            $this->int_id_contracto = $intContracto;
            $this->str_contracto = $contractoInput;
            $this->str_descripcion = $descriInput;
            $this->intEstado = $estadoInput;
            
            $sql = "SELECT * FROM contractos WHERE nombre_contracto = '$this->str_contracto'   and descripcion = '$this->str_descripcion' and id_contracto = $this->int_id_contracto";
            $request_update = $this->select_sql_all($sql);
            if(empty($request_update)){
                $sql_update = "UPDATE contractos SET nombre_contracto = ?,descripcion = ?,estado = ?,fecha_modifica = now() WHERE id_contracto = $this->int_id_contracto";
                $data = array($this->str_contracto,$this->str_descripcion,$this->intEstado);
                $request_update = $this->update_sql($sql_update,$data);
            }else{
                $request_update = "exist";
            }
            return $request_update;
        }


        public function deleteContracto(int $id_contracto){
            $this->int_id_contracto = $id_contracto;
            $sql = "SELECT * FROM empleados WHERE id_contracto = $this->int_id_contracto";
            $request_delete = $this->select_sql_all($sql);
            if(empty($request_delete)){
                $sql = "UPDATE contractos set estado = ? , fecha_modifica = now() WHERE id_contracto = $this->int_id_contracto";
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