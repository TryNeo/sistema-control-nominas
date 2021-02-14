<?php
    require_once ("./libraries/core/conexion.php");
    class Mysql extends Conexion{
        private $conexion;
        private $strquery;
        private $arrValues;

        function __construct(){
            $this->conexion = (new Conexion())->connect();
        }

        /* Insetar registro */
        public function insert_sql(string $query,array $arrVAlues){
            $this->strquery = $query;
            $this->arrValues = $arrVAlues;
            $insert_sql =  $this->conexion->prepare($this->strquery);
            $resInsert_sql = $insert_sql->execute($this->arrValues);
            if($resInsert_sql){
                $lastInsert_sql = $this->conexion->lastInsertId();
            }else{
                $lastInsert_sql = 0;
            }
            return $lastInsert_sql;
        }

        /* Selecionar un registro */
        public function select_sql(string $query){
            $this->strquery = $query;
            $result  = $this->conexion->prepare($this->strquery);
            $result->execute();
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        /* Selecionar registros todos */ 
        public function select_sql_all(string $query){
            $this->strquery = $query;
            $result  = $this->conexion->prepare($this->strquery);
            $result->execute();
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        /* Actualizar registros */
        public function update_sql(string $query,array $arrValues){
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            $update_sql =  $this->conexion->prepare($this->strquery);
            $resUpdate_sql = $update_sql->execute($this->arrValues);
            return $resUpdate_sql;
        }


        /* Eliminar registros */
        public function delete_sql(string $query){
            $this->strquery = $query;
            $delete_sql =  $this->conexion->prepare($this->strquery);
            $delete_sql->execute();
            return $delete_sql;
        }

        public function select_count(string $query){
            $this->strquery = $query;
            $count_sql = $this->conexion->prepare($this->strquery);
            $count_sql->execute();
            return $count_sql->rowCount();
        }
    }

?>