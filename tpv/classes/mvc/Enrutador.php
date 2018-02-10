<?php

class Enrutador {
    
    private $rutas = array();

    function __construct() {
        $this->rutas['index'] = new Ruta('Modelo' , 'Vista' , 'Controlador');
        $this->rutas['product'] = new Ruta('ModeloProduct' , 'Vista' , 'ControladorProduct');
        $this->rutas['member'] = new Ruta('ModeloMember' , 'Vista' , 'ControladorMember');
        $this->rutas['client'] = new Ruta('ModeloClient' , 'Vista' , 'ControladorClient');
        $this->rutas['family'] = new Ruta('ModeloFamily' , 'VistaAjax' , 'ControladorFamily');
        
        /******************************************************************/
        $this->rutas['ticket'] = new Ruta('ModeloTicket' , 'Vista' , 'ControladorTicket');
        $this->rutas['ticket_ajax'] = new Ruta('ModeloTicket' , 'VistaAjax' , 'ControladorTicket');
        /******************************************************************/
        
        /******************************************************************/
        $this->rutas['product_ajax'] = new Ruta('ModeloProduct', 'VistaAjax', 'ControladorProduct');
        /******************************************************************/
        
        /******************************************************************/
        $this->rutas['client_ajax'] = new Ruta('ModeloClient','VistaAjax','ControladorClient');
        /******************************************************************/
        
        /******************************************************************/
        $this->rutas['ticket_detail_ajax'] = new Ruta('ModeloTicketDetail','VistaAjax','ControladorTicketDetail');
        /******************************************************************/
        
        
        $this->rutas['tpv'] = new Ruta('Modelo' , 'Vista' , 'ControladorTpv');
        
        $this->rutas['carrito'] = new Ruta('ModeloProduct' , 'VistaAjax' , 'Controlador');
    }

    function getRoute($ruta) {
        if (!isset($this->rutas[$ruta])) {
            return $this->rutas['index'];
        }
        return $this->rutas[$ruta];
    }
}