<?php

class ModeloClient extends Modelo{
    
    function getAll(){
        $manager = new ManagerClient($this->getDataBase());
        return $manager->getAll();
    }

    
    function getAllLimit($rows,$page){
        $manager = new ManagerClient($this->getDataBase());
        return $manager->getAllLimit($rows,$page);
    }
    
    function getRows(){
        $manager = new ManagerClient($this->getDataBase());
        return $manager->count();
    }
    
    function insertClientBD($client){
        $manager = new ManagerClient($this->getDataBase());
        return $manager->add($client);
    }
    
    //devuelve un cliente a partir de id
    function getClient($id){
        $manager = new ManagerClient($this->getDataBase());
        return $manager->get($id);
    }
    
    //eliminar cliente de la BD
    function removeClientBD($id){
        $manager = new ManagerClient($this->getDataBase());
        return $manager->remove($id);
    }
    
    function editClient($client){
        $manager = new ManagerClient($this->getDataBase());
        return $manager->edit($client);
    }
    
    function getAllAjax(){
        $manager = new ManagerClient($this->getDataBase());
        return $manager->getAllAjax();
    }
}