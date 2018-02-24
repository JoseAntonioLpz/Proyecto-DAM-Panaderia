<?php

class Ticket{
    
    use Utilidades;
    
    private $id, $date , $idmember, $idclient;
    
    function __construct($id = 0 , $date = '00-00-0000' , $idmember = null , $idclient = null){
        $this->id = $id;
        $this->date = $date;
        $this->idmember = $idmember;
        $this->idclient = $idclient;
    }
    
    function getId(){
        return $this->id;
    }
    
    function setId($id){
        $this->id = $id;
    }
    
    function getDate(){
        return $this->date;
    }
    
    function setDate($date){
        $this->date = $date;
    }
    
    function getIdMember(){
        return $this->idmember;
    }
    
    function setIdMember($idmember){
        $this->idmember = $idmember;
    }
    
    function getIdClient(){
        return $this->idclient;
    }
    
    function setIdClient($idclient){
        $this->idclient = $idclient;
    }
    
}