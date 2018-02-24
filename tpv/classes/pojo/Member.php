<?php

class Member{
    
    use Utilidades;
    
    private $id, $login, $clave;
    
    function __construct($id = 0 , $login = '' , $clave = ''){
        $this->id = $id;
        $this->login = $login;
        $this->clave = $clave;
    }
    
    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }
    
    function getLogin(){
        return $this->login;
    }
    
    function setLogin($login){
        $this->login = $login;
    }
    
    function getClave(){
        return $this->clave;
    }
    
    function setClave($clave){
        $this->clave = $clave;
    }
}