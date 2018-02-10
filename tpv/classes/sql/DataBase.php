<?php

class DataBase {
    
    private $con, $sentencia;
            
    function __construct($clase = 'Constant') {
        try{
            $this->con = new PDO(
                'mysql:host=' . $clase::SERVER . ';dbname=' . $clase::DATABASE,
                $clase::USER,
                $clase::PASS,
                array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8'
                )
            ); 
        }catch(PDOException $e){
            //echo $e->errorInfo();
            $this->con = null;
        }
    }
    function execute($sql , array $params = array()){
        $this->sentencia = $this->con->prepare($sql);
        foreach ($params as $nameParam => $value) {
            if(is_array($value)) {
                $this->sentencia->bindValue($nameParam , $value[0], $value[1]);
            } else {
                $this->sentencia->bindValue($nameParam , $value);
            }
        }
        $r = $this->sentencia->execute();
        /*
        echo $sql . '<br>';
        echo Util::varDump($params);
        echo Util::varDump($this->sentencia->errorInfo());
        echo Util::varDump($this->sentencia);
        //*/
        return $r;
    }
    
    function isConnected(){
        return $this->con !== null;
    }
    
    function closeConnection(){
        $this->con = null;
    }
    
    function getRowNumber(){
        return $this->sentencia->rowCount();
    }
    
    function getId(){
        return $this->con->lastInsertId();
    }
    
    function getStatement(){
        return $this->sentencia;
    }
}
