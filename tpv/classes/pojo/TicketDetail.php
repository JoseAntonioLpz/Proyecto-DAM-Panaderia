<?php

class TicketDetail{
    
    use Utilidades;
        
    private $id, $idticket, $idproduct, $quantity, $price;
    
    function __construct($id = null, $idticket = null, $idproduct = null, $quantity = null, $price = null){
        $this->id = $id;
        $this->idticket = $idticket;
        $this->idproduct = $idproduct;
        $this->quantity = $quantity;
        $this->price = $price;
    }
    
    function getId() {
        return $this->id;
    }

    function getIdticket() {
        return $this->idticket;
    }

    function getIdproduct() {
        return $this->idproduct;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function getPrice() {
        return $this->price;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdticket($idticket) {
        $this->idticket = $idticket;
    }

    function setIdproduct($idproduct) {
        $this->idproduct = $idproduct;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    function setPrice($price) {
        $this->price = $price;
    }
    
}