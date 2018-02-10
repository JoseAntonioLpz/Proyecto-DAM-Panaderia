<?php

class ModeloTicketDetail extends Modelo{

    function insertTicketDetail($tDetail){
        $manager = new ManagerTicketDetail($this->getDataBase());
        return $manager->add($tDetail);
    }
    
    function get($id){
        $manager = new ManagerTicketDetail($this->getDataBase());
        return $manager->getJoinWithProduct($id);
    }
    
    function removeDetails($id){
        $manager = new ManagerTicketDetail($this->getDataBase());
        return $manager->remove($id);
    }
}