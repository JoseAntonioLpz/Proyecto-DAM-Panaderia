<?php

class ControladorTicket extends Controlador{
    
    function index(){
        if($this->isLogged()){
            $this->getTickets();
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    function addTicket(){
        if($this->isLogged()){
            $idClient = Request::read('idclient');
            $ticket = new Ticket(0 , date("Y-m-d H:i:s"), $this->getUser()->getId(), $idClient);
            $idTicket = $this->getModel()->insertTicket($ticket);
            $res = array('id' => $idTicket);
            $this->getModel()->setDato('data' , $res);
        }else{
            
        }
    }
    
    function removeTicket(){
        if($this->isLogged()){
            $idTicket = Request::read('id');
            $res = $this->getModel()->removeTicket($idTicket);
            $this->getModel()->setDato('data' , $res);
        }else{
            
        }
    }
    
    function getTickets(){
        if($this->isLogged()){
            $tickets = $this->getModel()->getAllTickets();
            $this->getModel()->setDato('data' , $tickets);
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    function getOneTicket(){
        if($this->isLogged()){
            
        }else{
            
        }
    }
    
    function ticketTemplate(){
        if($this->isLogged()){
            $this->getModel()->setDato('archivo' , Util::includeTemplates('templates/tickets/_ticket_list.html'));
        }else{
            $this->getModel()->setDato('archivo' , Util::includeTemplates('templates/first_page.html'));
        }
    }
    
    function clean_tickets(){
        if($this->isLogged()){
            $res = $this->getModel()->clean();
            $this->getModel()->setDato('data' , $res);
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    function getAllTicketsJoin(){ //FALLO SQL
        if($this->isLogged()){
            $rows = $this->getModel()->getCount();
            $pagination = new Pagination($rows , Request::read('page') , 10);
            $a = $pagination->getOffset();
            $b = $pagination->getRpp();
            $order = Request::read('order');
            $rango = array(
                'first' => $pagination->getFirst(),
                'last' => $pagination->getLast(),
                'next' => $pagination->getNext(),
                'previous' => $pagination->getPrevious(),
                'range' => $pagination->getRange()
            );
            $tickets = $this->getModel()->getAllWithJoin($a , $b, $order);
            $this->getModel()->setDato('data' , $tickets);
            $this->getModel()->setDato('pagination' , $rango);
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    function register_ticket(){
        if($this->isLogged()){
            $ticket = $this->getModel()->getOneTicket(Request::read('idTicket'));
            $idClient = Request::read('idClient');
            if($ticket !== null){
                $ticket->setIdClient($idClient);
                $res = $this->getModel()->registerTicket($ticket);
                $res = array('res' => $res);
                $this->getModel()->setDato('res',$res);
            }
        }else{
            $this->getModel()->setDato('archivo' , Util::includeTemplates('templates/first_page.html'));
        }
    }
}