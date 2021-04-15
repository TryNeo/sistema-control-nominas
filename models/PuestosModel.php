<?php
    require_once("./libraries/core/mysql.php");
    class PuestosModel extends Mysql{
        public $int_id_puesto;
        public $str_puesto;
        public $str_descripcion;
        public $intEstado;

        public function __construct(){
            parent::__construct();
        }


        public function selectPuestos(){
            $sql = "SELECT id_puesto,nombre_puesto,descripcion,estado FROM puestos";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectPuestosNoInactivos(){
            $sql = "SELECT id_puesto,nombre_puesto,descripcion,estado FROM puestos WHERE estado!=0";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectPuesto(int $id_puesto){
            $this->int_id_puesto = $id_puesto;
            $sql = "SELECT id_puesto,nombre_puesto,descripcion,estado FROM puestos WHERE id_puesto = $this->int_id_puesto";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function insertPuesto(string $puestoInput, string $descriInput, int $estadoInput){
            $return = "";
            $this->str_puesto =  $puestoInput;
            $this->str_descripcion = $descriInput;
            $this->intEstado = $estadoInput;
            $sql = "SELECT * FROM puestos WHERE nombre_puesto = '{$this->str_puesto}'";
            $request = $this->select_sql_all($sql);
            if (empty($request)){
                $sql_insert = "INSERT INTO puestos(nombre_puesto,descripcion,estado,fecha_crea) values (?,?,?,now())";
                $data = array($this->str_puesto,$this->str_descripcion,$this->intEstado);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updatePuesto(int $intPuesto,string $puestoInput,string $descriInput,int $estadoInput){
            $this->int_id_puesto = $intPuesto;
            $this->str_puesto = $puestoInput;
            $this->str_descripcion = $descriInput;
            $this->intEstado = $estadoInput;
            
            $sql = "SELECT * FROM puestos WHERE nombre_puesto = '$this->str_puesto' and id_puesto = $this->int_id_puesto and estado!=0";
            $request_update = $this->select_sql_all($sql);
            if(empty($request_update)){
                $sql_update = "UPDATE puestos SET nombre_puesto = ?,descripcion = ?,estado = ?,fecha_modifica = now() WHERE id_puesto = $this->int_id_puesto";
                $data = array($this->str_puesto,$this->str_descripcion,$this->intEstado);
                $request_update = $this->update_sql($sql_update,$data);
            }else{
                $request_update = "exist";
            }
            return $request_update;
        }

        public function deletePuesto(int $id_puesto){
            $this->int_id_puesto = $id_puesto;
            $sql = "SELECT * FROM empleados WHERE id_puesto = $this->int_id_puesto";
            $request_delete = $this->select_sql_all($sql);
            if(empty($request_delete)){
                $sql = "UPDATE puestos set estado = ? , fecha_modifica = now() WHERE id_puesto = $this->int_id_puesto";
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