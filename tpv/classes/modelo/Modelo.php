<?php

class Modelo {
    
    private $dataBase;
    private $datos;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function getDato($nombre) {
        if(isset($this->datos[$nombre])){
             return $this->datos[$nombre];
        }
        return null;
    }
    
    function getDatos() {
        return $this->datos;
    }

    function setDato($nombre, $dato) {
        $this->datos[$nombre] = $dato;
    }
    
    function getDataBase(){
        return $this->dataBase;
    }
    
    function setDatos($datos) {
        foreach($datos as $atributo => $dato){
            $this->setDato($atributo , $dato);
        }
    }
}