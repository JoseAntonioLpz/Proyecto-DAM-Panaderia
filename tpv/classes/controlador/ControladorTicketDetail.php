<?php

class ControladorTicketDetail extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    /*function save_ticket(){
        $ticketDetails = json_decode(Request::read('ticketdetails'));//recibo array con datos
        $res = -1;
        $res = array();
        for($i = 0;$i < count($ticketDetails);$i++){
            $tDetail = new TicketDetail();
            $tDetail->setIdticket(Request::read('idticket'));
            $tDetail->setQuantity($ticketDetails[$i][0]);
            $tDetail->setIdproduct($ticketDetails[$i][1]);
            $tDetail->setPrice($ticketDetails[$i][4]);
            $res[] = $this->getModel()->insertTicketDetail($tDetail);
        }
        $this->getModel()->setDato('res',$res);
    }*/
    
    function save_ticket(){
        $carrito = $this->getSession()->getCarro()->getCarrito();//obtengo carrito de la compra
        $res = array();
        
        foreach($carrito as $linea){
           $tDetail = new TicketDetail();
           //$producto = $linea->getItem();
           $tDetail->setIdticket(Request::read('idticket'));
           $tDetail->setIdproduct($linea['item']['id']);
           $tDetail->setQuantity($linea['cantidad']);
           $tDetail->setPrice($linea['item']['price'] * $linea['cantidad']);
           
           $res[] = $this->getModel()->insertTicketDetail($tDetail);
        }
        $this->getModel()->setDato('res',$res);
    }
    
    function get_details(){
        $id = Request::read('id');
        if($this->isLogged()){
            $res = $this->getModel()->get($id);
            $this->getModel()->setDato('data', $res);
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
    
    function removeTicketDetails(){
        $id = Request::read('id');
        if($this->isLogged()){
            $res = $this->getModel()->removeDetails($id);
            $this->getModel()->setDato('data', $res);
        }else{
            $this->getModel()->setDato('data', '');
        }
    }
    
}