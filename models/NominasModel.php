<?php
    require_once("./libraries/core/mysql.php");
    class NominasModel extends Mysql{
        public $int_id_nomina;
        public $str_nombre_nomina;
        public $date_periodo_inicio;
        public $date_periodo_fin;
        public $int_estado_nomina;
        public $int_estado;

        public function __construct(){
            parent::__construct();
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