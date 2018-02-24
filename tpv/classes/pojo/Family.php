<?php

class Family{
    
    use Utilidades;
    
    private $id, $family;
    
    function __construct($id = 0 , $family = ''){
        $this->id = $id;
        $this->family = $family;
    }
    
    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }
    
    function getFamily(){
        return $this->id;
    }
    
    function getFamilyName(){
        return $this->family;
    }
    
    
    function setFamily($id){
        $this->id = $id;
    }
}