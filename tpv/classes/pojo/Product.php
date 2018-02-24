<?php

class Product {
    
    use Utilidades;

    private $id, 
            $idfamily,
            $product,
            $price,
            $description;
    
    function __construct($id = null, 
                        $idfamily = null,
                        $product = null,
                        $price = null,
                        $description = null) {
        $this->id = $id;
        $this->idfamily = $idfamily;
        $this->product = $product;
        $this->price = $price;
        $this->description = $description;
    }

    function getId() {
        return $this->id;
    }

    function getIdfamily() {
        return $this->idfamily;
    }
    
    function getProduct() {
        return $this->product;
    }
    
    function getPrice() {
        return $this->price;
    }

    function getDescription() {
        return $this->description;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdfamily($idfamily) {
        $this->idfamily = $idfamily;
    }

    function setProduct($product) {
        $this->product = $product;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function verify(){
        $ok = true;
        if ($this->getProduct() == ''){
            $ok = false;
        }
        if ($this->getPrice() == '' || !is_numeric($this->getPrice())){
            $ok = false;
        }
        return $ok;
    }
    
    
}