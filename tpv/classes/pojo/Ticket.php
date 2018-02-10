<?php

class Ticket{
    
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
    
    
    function getAttributes(){
        $atributos = [];
        foreach($this as $atributo => $valor){
            $atributos[] = $atributo;
        }
        return $atributos;
    }

    function getValues(){
        $valores = [];
        foreach($this as $valor){
            $valores[] = $valor;
        }
        return $valores;
    }
    
    
    function getAttributesValues(){
        $valoresCompletos = [];
        foreach($this as $atributo => $valor){
            $valoresCompletos[$atributo] = $valor;
        }
        return $valoresCompletos;
    }
    
    function read(){
        foreach($this as $atributo => $valor){
            $this->$atributo = Request::read($atributo);
        }
    }
    
    function set(array $array, $pos = 0){
        foreach ($this as $campo => $valor) {
            if (isset($array[$pos]) ) {
                $this->$campo = $array[$pos];
            }
            $pos++;
        }
    }
    
    function setFromAssociative(array $array){
        foreach($this as $indice => $valor){
            if(isset($array[$indice])){
                $this->$indice = $array[$indice];
            }
        }
    }
    
    public function __toString() {
        $cadena = get_class() . ': ';
        foreach($this as $atributo => $valor){
            $cadena .= $atributo . ': ' . $valor . ', ';
        }
        return substr($cadena, 0, -2);
    }
}