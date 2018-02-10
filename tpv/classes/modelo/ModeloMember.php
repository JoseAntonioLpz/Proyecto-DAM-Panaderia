<?php

class ModeloMember extends Modelo{
    
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct() {
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerMember($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function insertUser($member){
        return $this->gestor->add($member);
    }
    
    function getUser($id){
        return $this->gestor->get($id);
    }
    
    function getPaginateUser($a, $b){
        return $this->gestor->getAllLimit($a, $b);
    }
    
    function getCount(){
        return $this->gestor->getAllCount();
    }
    
    function getUserWhitLogin($login){
        return $this->gestor->getWithLogin($login);
    }
    
    function getAllUser(){
        return $this->gestor->getAll();
    }
    
    function editUser($param , $member){
        switch ($param) {
            case 'All':
                return $this->gestor->edit($member);
                break;
            case 'NoPass':
                return $this->gestor->editWithoutPass($member);
                break;
            default:
                return 0;
                break;
        }
    }
    
    function removeUser($id){
        return $this->gestor->remove($id);
    }
}