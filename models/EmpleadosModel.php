<?php
    require_once("./libraries/core/mysql.php");
    class EmpleadosModel extends Mysql{
        public $int_id_empleado;
        public $str_nombrre;
        public $str_apellido;
        public $str_cedula;
        public $str_telefono;
        public $float_sueldo;
        public $int_id_puesto;
        public $int_id_contrato;
        public $int_estado;


        public function __construct(){
            parent::__construct();
        }

        public function getTotalEmpleado(){
            $query = "SELECT * FROM empleados WHERE estado !=0";
            $request_query = $this->select_count($query);
            return $request_query;
        }

        public function getTotalSueldo(){
            $query = "SELECT SUM(sueldo) as total FROM empleados WHERE estado !=0";
            $request = $this->select_sql_all($query);
            return $request;
        }

        public function selectEmpleados(){
            $sql = "SELECT empl.id_empleado,empl.nombre,empl.apellido,empl.cedula,empl.telefono,
            empl.sueldo,puest.nombre_puesto,cont.nombre_contrato,empl.estado FROM empleados as empl 
            INNER JOIN contratos as cont ON empl.id_contrato = cont.id_contrato 
            INNER JOIN puestos as puest ON empl.id_puesto = puest.id_puesto";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectEmpleadosReporte(){
            $sql = "SELECT empl.id_empleado,empl.cedula,empl.nombre,empl.apellido,empl.telefono,empl.sueldo,puest.nombre_puesto FROM empleados as empl 
            INNER JOIN contratos as cont ON empl.id_contrato = cont.id_contrato 
            INNER JOIN puestos as puest ON empl.id_puesto = puest.id_puesto ORDER BY empl.id_empleado ASC";
            $request = $this->select_sql_all($sql);
            return $request;
        }



        public function selectEmpleado(int $id_empleado){
            $this->int_id_empleado = $id_empleado;
            $sql = "SELECT empl.id_empleado,empl.nombre,empl.apellido,empl.cedula,empl.telefono,
            empl.sueldo,puest.id_puesto,cont.id_contrato,empl.estado FROM empleados as empl 
            INNER JOIN contratos as cont ON empl.id_contrato = cont.id_contrato 
            INNER JOIN puestos as puest ON empl.id_puesto = puest.id_puesto 
            WHERE empl.id_empleado = $this->int_id_empleado";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function insertEmpleado(string $str_nombre,string $str_apellido,string $str_cedula,
        string $str_telefono,float $float_sueldo,int $int_id_puesto,int $int_id_contrato,int $int_estado)
        {
            $return = 0;
            $this->str_nombre = $str_nombre;
            $this->str_apellido = $str_apellido;        
            $this->str_cedula = $str_cedula;
            $this->str_telefono = $str_telefono;
            $this->float_sueldo = $float_sueldo;
            $this->int_id_puesto = $int_id_puesto;
            $this->int_id_contrato = $int_id_contrato;
            $this->int_estado = $int_estado;
            $sql = "SELECT * FROM empleados WHERE cedula = '{$this->str_cedula}'";
            $request = $this->select_sql_all($sql);
            if(empty($request)){
                $sql_insert = "INSERT INTO empleados (nombre,apellido,cedula,telefono,sueldo,id_puesto,id_contrato,estado,fecha_crea) values (?,?,?,?,?,?,?,?,now())";
                $data = array($this->str_nombre,$this->str_apellido,$this->str_cedula,
                $this->str_telefono,$this->float_sueldo,$this->int_id_puesto,$this->int_id_contrato,$this->int_estado);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateEmpleado(int $id_empleado,string $str_nombre,string $str_apellido,string $str_cedula,
        string $str_telefono,float $float_sueldo,int $int_id_puesto,int $int_id_contrato,int $int_estado)
        {
            $this->int_id_empleado = $id_empleado;
            $this->str_nombre = $str_nombre;
            $this->str_apellido = $str_apellido;        
            $this->str_cedula = $str_cedula;
            $this->str_telefono = $str_telefono;
            $this->float_sueldo = $float_sueldo;
            $this->int_id_puesto = $int_id_puesto;
            $this->int_id_contrato = $int_id_contrato;
            $this->int_estado = $int_estado;
            $sql_update = "UPDATE empleados SET nombre = ?,apellido = ?,cedula = ?,telefono = ?,
            sueldo = ?,id_puesto = ?,id_contrato = ?,estado = ?,fecha_modifica = now() WHERE id_empleado = $this->int_id_empleado";
            $data = array($this->str_nombre,$this->str_apellido,$this->str_cedula,
            $this->str_telefono,$this->float_sueldo,$this->int_id_puesto,$this->int_id_contrato,$this->int_estado);
            $request_update = $this->update_sql($sql_update,$data);              
            return $request_update;
        }        

        public function deleteEmpleado(int $id_empleado){
            $this->int_id_empleado = $id_empleado;
            $sql = "UPDATE empleados SET estado = ?, fecha_modifica = now() WHERE id_empleado = $this->int_id_empleado";
            $data = array(0);
            $request_delete = $this->update_sql($sql,$data);
            return $request_delete;
        }

    }

?>