<?php
    require_once("./libraries/core/mysql.php");
    class NominasModel extends Mysql{
        public $int_id_nomina;
        public $int_id_empleado;
        public $str_nombre_nomina;
        public $date_periodo_inicio;
        public $date_periodo_fin;
        public $int_estado_nomina;
        public $int_estado;

        public function __construct(){
            parent::__construct();
        }

        public function selectNominas(){
            $sql = "SELECT nom.id_nomina,
            nom.nombre_nomina,
            nom.periodo_inicio,
            nom.periodo_fin,
            nom.nota,
            nom.total,
            nom.estado_nomina,
            nom.estado
            FROM nominas as nom";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectNomina(int $int_id_nomina){
            $this->int_id_nomina = $int_id_nomina;
            $sql = "SELECT nom.id_nomina,
                    nom.nombre_nomina,
                    nom.periodo_inicio,
                    nom.periodo_fin,
                    nom.estado_nomina
                    FROM nominas as nom WHERE nom.id_nomina = $this->int_id_nomina";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function selectNominaEmpleado(){
            $sql = "SELECT empl.id_empleado,empl.nombre,empl.apellido FROM empleados as empl WHERE estado!=0";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectSearchNominaEmpleado(int $id_empleado){
            $this->int_id_empleado = $id_empleado;
            $sql = "SELECT empl.id_empleado,empl.nombre,empl.apellido FROM empleados as empl WHERE empl.id_empleado = $this->int_id_empleado and estado!=0";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function insertNomina(string $str_nombre_nomina, string $date_periodo_inicio,
        string $date_periodo_fin ,int $int_estado_nomina,int $int_estado){
            $this->str_nombre_nomina = $str_nombre_nomina;
            $this->date_periodo_inicio = $date_periodo_inicio;
            $this->$date_periodo_fin = $date_periodo_fin;
            $this->$int_estado_nomina = $int_estado_nomina;
            $this->$int_estado = $int_estado;
            $sql_insert = "INSERT INTO nominas(nombre_nomina,periodo_inicio,periodo_fin,
            estado_nomina,estado,fecha_crea) values (?,?,?,?,?,now())";
            $data = array($this->str_nombre_nomina,$this->date_periodo_inicio,$this->$date_periodo_fin,$this->$int_estado_nomina,$this->$int_estado);
            $request_insert = $this->insert_sql($sql_insert,$data);
            $return = $request_insert;
            return $return;
        }

    }
?>