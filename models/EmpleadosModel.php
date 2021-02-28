<?php
    require_once("./libraries/core/mysql.php");
    class EmpleadosModel extends Mysql{
        public $int_id_empleado;
        public $str_nombrre;
        public $str_apellido;
        public $str_cedula;
        public $str_email;
        public $str_telefono;
        public $str_sueldo;
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
    }

?>