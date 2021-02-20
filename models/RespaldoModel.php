<?php
    require_once("./libraries/core/mysql.php");
    class RespaldoModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function respaldo_sql(string $query){
            $con=mysqli_connect("localhost","root","","nominas_bd");
            mysqli_set_charset($con, "utf8");
            if (mysqli_connect_errno()) {
                printf("Conexion fallida: %s\n", mysqli_connect_error());
                exit();
            }else{
                mysqli_autocommit($con, false);
                mysqli_begin_transaction($con, MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
                if($consul=mysqli_query($con, $query)){
                    if (!mysqli_commit($con)) {
                        exit();
                    }
                }else{
                    mysqli_rollback($con);
                    exit();
                }
                return $consul;
            }
        }

        public function restore_sql(string $route){
            $sql=explode(";",file_get_contents($route));
            $totalErrors=0;
            set_time_limit (60);
            $con = new mysqli("localhost","root","","nominas_bd");
            $con->query("SET FOREIGN_KEY_CHECKS=0");
            for($i = 0; $i < (count($sql)-1); $i++){
                if($con->query($sql[$i].";")){  }else{ $totalErrors++; }
            }
            $con->query("SET FOREIGN_KEY_CHECKS=1");
            $con->close();
            if($totalErrors<=0){
                return true;
            }else{
                return false;
            }
        }
    }

?>