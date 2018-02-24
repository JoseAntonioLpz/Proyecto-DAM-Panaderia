<?php 

class ModeloTicket extends Modelo{
    
    private $dataBase;
    private $datos;
    private $gestor;
    
    function __construct(){
        $this->dataBase = new DataBase();
        $this->datos = array();
        $this->gestor = new ManagerTicket($this->dataBase);
    }
    
    function __destruct() {
        $this->dataBase->closeConnection();
    }
    
    function insertTicket($ticket){
        return $this->gestor->add($ticket);
    }
    
    function getOneTicket($id){
        return $this->gestor->get($id);
    }
    
    function getAllTickets(){
        return $this->gestor->getAllJoinMemberAndClient();
    }
    
    function getAllWithJoin($a, $b, $order){
        return $this->gestor->getAllJoinMemberAndClientLimit($a, $b, $order);
    }
    
    function getCount(){
        return $this->gestor->getCount();
    }
    
    function registerTicket($ticket){
        return $this->gestor->editTicketIdClient($ticket);
    }
    
    function removeTicket($idTicket){
        return $this->gestor->remove($idTicket);
    }
    
    function clean(){
        return $this->gestor->clean();
    }
    
    function search($param, $criterio){
        switch ($param) {
            case 'date':
                return $this->gestor->searchDate($criterio);
                break;
            case 'text':
                return $this->gestor->search($criterio);
                break;
        }
        
    }
}