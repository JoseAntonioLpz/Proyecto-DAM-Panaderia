<?php 

class ModeloFamily extends Modelo{
    
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct(){
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerFamily($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function getFamily($id){
        return $this->gestor->get($id);
    }
    
    function getAllFamilys(){
        return $this->gestor->getAll();
    }
}