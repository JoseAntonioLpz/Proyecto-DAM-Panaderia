<?php

class ControladorFamily extends Controlador{
    
    function index(){
        if($this->isLogged()){
            $this->getFamilys();
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    function getFamilys(){
        if($this->isLogged()){
            $familias = $this->getModel()->getAllFamilys();
            $this->getModel()->setDato('data' , $familias);
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
}