<?php

class ControladorWp extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        $res = $this->getModel()->getCountFromWp();    
        $this->getModel()->setDato('data', $res);
    }
}