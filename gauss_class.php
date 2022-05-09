<?php

class gauss
{
    private $conn;//数据库连接资源号

    public function __construct($host,$user,$pass,$dbname,$port='8888'){
        $c_host = 'host='.$host;
        $c_port = 'port='.$port;
        $c_dbname = 'dbname='.$dbname;
        $c_credentials='user='.$user.' password='.$pass;
        $conn = pg_connect("$c_host $c_port $c_dbname $c_credentials");
        $this->conn = $conn;
        if (!$conn) {
            echo "数据库连接失败";
            return false;
        } else {
            return $conn;
        }
    }

    public function __destruct(){
        pg_close($this->conn);
    }

    function isbusy(){
        $bs = pg_connection_busy($this->conn);
        if ($bs) {
            return true;
        }
        else {
            return false;
        }
    }
    function query($sql){
        return pg_query($this->conn,$sql);
    }
    function getAll($sql){
        $result = $this->query($sql);
        $data = array();
        if ($result && $this->numRows($result)>0){
            while ($row = pg_fetch_assoc($result)){
                $data[] = $row;
            }
        return $data;
        }

    }

    function getOne($sql){
        $result = $this->query($sql);
        $data = array();
        if ($result && $this->numRows($result)>0){
            $data = pg_fetch_assoc($result);
        }
        return $data;
    }

    function numRows($result){
        return pg_num_rows($result);
    }

    function  affactedRows($result){
        return pg_affected_rows($result);
    }
    function insert($table,$data){
        $sql = "INSERT INTO ".$table." (".implode(",",array_keys($data)).") VALUES ('".implode("','",$data)."')";
        $res = $this->query($sql);
        if ($res && $this->affactedRows($res)>0){
            return true;
        }
        else{
            return false;
        }
    }

    function update($table,$data,$where){
        $sql = "UPDATE ".$table." SET ";
        foreach ($data as $key => $value){
            $sql .= "{$key} ='{$value}',";
        }
        $sql = rtrim($sql,',');
        $sql .= " WHERE ".$where;
        $res = $this->query($sql);
        if ($res && $this->affactedRows($res)>0){
            return true;
        }
        else{
            return false;
        }
    }

    function del($table,$where){
        $sql = "DELETE FROM ".$table." WHERE ".$where;
        $res = $this->query($sql);
        if ($res && $this->affactedRows($res)>0){
            return true;
        }
        else{
            return false;
        }
    }
    function connReset(){
        return pg_connection_reset($this->conn);
    }

    function dbName(){
        return pg_dbname($this->conn);
    }

    function fetch_all($result){
        return pg_fetch_all($result);
    }

    function fetch_array($result){
        return pg_fetch_array($result);
    }

    function fetch_assos($result){
        return pg_fetch_assoc($result);
    }
}