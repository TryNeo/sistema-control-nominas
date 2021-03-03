<?php
    require_once("./libraries/core/mysql.php");
    class EmpleadosModel extends Mysql{
        public $int_id_empleado;
        public $str_nombrre;
        public $str_apellido;
        public $str_cedula;
        public $str_email;
        public $str_telefono;
        public $float_sueldo;
        public $int_id_contracto;
        public $int_estado;


        public function __construct(){
            parent::__construct();
        }

        public function selectEmpleados(){
            $sql = "SELECT empl.id_empleado,empl.nombre,empl.apellido,empl.cedula,empl.telefono,
            empl.sueldo,cont.nombre_contracto,empl.estado FROM empleados as empl 
            INNER JOIN contractos as cont ON empl.id_contracto = cont.id_contracto WHERE empl.estado !=0";
            $request = $this->select_sql_all($sql);
            return $request;
        }


        public function selectEmpleado(int $id_empleado){
            $this->int_id_empleado = $id_empleado;
            $sql = "SELECT empl.id_empleado,empl.nombre,empl.apellido,empl.cedula,empl.email,empl.telefono,
            empl.sueldo,cont.id_contracto,empl.estado FROM empleados as empl 
            INNER JOIN contractos as cont ON empl.id_contracto = cont.id_contracto WHERE empl.id_empleado = $this->int_id_empleado";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function insertEmpleado(string $str_nombre,string $str_apellido,string $str_cedula,string $str_email,
        string $str_telefono,float $float_sueldo,int $int_id_contracto,int $int_estado)
        {
            $return = 0;
            $this->str_nombre = $str_nombre;
            $this->str_apellido = $str_apellido;        
            $this->str_cedula = $str_cedula;
            $this->str_email = $str_email;
            $this->str_telefono = $str_telefono;
            $this->float_sueldo = $float_sueldo;
            $this->int_id_contracto = $int_id_contracto;
            $this->int_estado = $int_estado;
         
            $sql = "SELECT * FROM empleados WHERE cedula = '{$this->str_cedula}' or email = '{$this->str_email}'";
            $request = $this->select_sql_all($sql);
            if(empty($request)){
                $sql_insert = "INSERT INTO empleados (nombre,apellido,cedula,email,telefono,sueldo,id_contracto,estado,fecha_crea) values (?,?,?,?,?,?,?,?,now())";
                $data = array($this->str_nombre,$this->str_apellido,$this->str_cedula,$this->str_email,
                $this->str_telefono,$this->float_sueldo,$this->int_id_contracto,$this->int_estado);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateEmpleado(int $id_empleado,string $str_nombre,string $str_apellido,string $str_cedula,string $str_email,
        string $str_telefono,float $float_sueldo,int $int_id_contracto,int $int_estado)
        {
            $this->int_id_empleado = $id_empleado;
            $this->str_nombre = $str_nombre;
            $this->str_apellido = $str_apellido;        
            $this->str_cedula = $str_cedula;
            $this->str_email = $str_email;
            $this->str_telefono = $str_telefono;
            $this->float_sueldo = $float_sueldo;
            $this->int_id_contracto = $int_id_contracto;
            $this->int_estado = $int_estado;

            $sql = "SELECT * FROM empleados WHERE  (cedula = '{$this->str_cedula}' and id_empleado=$this->int_id_empleado) 
            and (email = '{$this->str_email}'  and id_empleado=$this->int_id_empleado)";
            $request = $this->select_sql_all($sql);
            if(empty($request)){
                $sql_update = "UPDATE empleados SET nombre = ?,apellido = ?,cedula = ?,email = ?,telefono = ?,
                sueldo = ?,id_contracto = ?,estado = ?,fecha_modifica = now() WHERE id_empleado = $this->int_id_empleado";
                $data = array($this->str_nombre,$this->str_apellido,$this->str_cedula,$this->str_email,
                $this->str_telefono,$this->float_sueldo,$this->int_id_contracto,$this->int_estado);
                $request_update = $this->update_sql($sql_update,$data);              
            }else{
                $request_update= "exist";
            }
            return $request_update;
        }        

    }

?>