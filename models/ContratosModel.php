<?php
    require_once("./libraries/core/mysql.php");
    class ContratosModel extends Mysql{
        public $int_id_contrato;
        public $str_contrato;
        public $str_descripcion;
        public $intEstado;

        public function __construct(){
            parent::__construct();
        }


        public function selectContratos(){
            $sql = "SELECT id_contrato,nombre_contrato,descripcion,estado FROM contratos";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectContratosNoInactivos(){
            $sql = "SELECT id_contrato,nombre_contrato,descripcion,estado FROM contratos WHERE estado!=0";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectContrato(int $id_contrato){
            $this->int_id_contrato = $id_contrato;
            $sql = "SELECT id_contrato,nombre_contrato,descripcion,estado FROM contratos WHERE id_contrato = $this->int_id_contrato";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function insertContrato(string $contratoInput, string $descriInput, int $estadoInput){
            $return = "";
            $this->str_contrato =  $contratoInput;
            $this->str_descripcion = $descriInput;
            $this->intEstado = $estadoInput;
            $sql = "SELECT * FROM contratos WHERE nombre_contrato = '{$this->str_contrato}'";
            $request = $this->select_sql_all($sql);
            if (empty($request)){
                $sql_insert = "INSERT INTO contratos(nombre_contrato,descripcion,estado,fecha_crea) values (?,?,?,now())";
                $data = array($this->str_contrato,$this->str_descripcion,$this->intEstado);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateContrato(int $intContrato,string $contratoInput,string $descriInput,int $estadoInput){
            $this->int_id_contrato = $intContrato;
            $this->str_contrato = $contratoInput;
            $this->str_descripcion = $descriInput;
            $this->intEstado = $estadoInput;
            
            $sql = "SELECT * FROM contratos WHERE nombre_contrato = '$this->str_contrato' and id_contrato = $this->int_id_contrato and estado!=0";
            $request_update = $this->select_sql_all($sql);
            if(empty($request_update)){
                $sql_update = "UPDATE contratos SET nombre_contrato = ?,descripcion = ?,estado = ?,fecha_modifica = now() WHERE id_contrato = $this->int_id_contrato";
                $data = array($this->str_contrato,$this->str_descripcion,$this->intEstado);
                $request_update = $this->update_sql($sql_update,$data);
            }else{
                $request_update = "exist";
            }
            return $request_update;
        }


        public function deleteContrato(int $id_contrato){
            $this->int_id_contrato = $id_contrato;
            $sql = "SELECT * FROM empleados WHERE id_contrato = $this->int_id_contrato";
            $request_delete = $this->select_sql_all($sql);
            if(empty($request_delete)){
                $sql = "UPDATE contratos set estado = ? , fecha_modifica = now() WHERE id_contrato = $this->int_id_contrato";
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