<?php

class ModeloProduct extends Modelo {
    
    function getAllProducts($idfamily, $text, $page, $limit){
        $manager = new ManagerProduct($this->getDataBase());
        $array = $manager->getAll($idfamily, $text, $page, $limit);
        return $array;
    }
    
    function deleteProduct($id){
        $manager = new ManagerProduct($this->getDataBase());
        $res = $manager->remove($id);
        return $res;
    }
    
    function editProduct($product){
        $manager = new ManagerProduct($this->getDataBase());
        $res = $manager->edit($product);
        return $res;
    }
    
    function getProduct($id){
        $manager = new ManagerProduct($this->getDataBase());
        $product = $manager->get($id);
        return $product;
    }
    
    
    function getFamily($idfamily){
        $manager = new ManagerFamily($this->getDataBase());
        $family = $manager->get($idfamily);
        return $family->getFamilyName();
    }
    
    function getFamilyOptions(){
        $manager = new ManagerFamily($this->getDataBase());
        $array = $manager->getAll();
        $html = "";
        /**
         *Convierte el array asociativo de familias en un array numérico con un valor seguido de otro. 
         */
        foreach ($array as $family){
            foreach ($family as $value) {
                $idvalue[] = $value;
            }
        }
        
        /**
         * Bucle que genera un <option> por cada dos valores, es decir, 
         * id y nombre de familia.
         */
        $i = 0;
        while ($i < count($idvalue)){
            $f = 0;
            while (2 > $f){
                $html .= '<option value="'.$idvalue[$i+$f].'">'.$idvalue[$i+$f + 1].'</option>';
                $f = $f + 2;
            }
            $i = $i + 2;
        }
        return $html;
    }
    
    function getProductJson($id){
        $product = $this->getProduct($id);
        $json = $product->getAttributesValues();
        return $json;
    }
    
    function getAllProductsJson($idfamily, $text, $page, $limit){
        $products = $this->getAllProducts($idfamily, $text, $page, $limit);
        $json = array();
        foreach($products as $product) {
            $product->setIdfamily($this->getFamily($product->getIdfamily()));
            $json[] = $product->getAttributesValues();
        }
        return $json;
    }
    
    function getAllFromWP($a, $b){
        $manager = new ManagerProduct($this->getDataBase());
        return $manager->getAllFromWP($a, $b);
    }
    
    function getCount(){
        $manager = new ManagerProduct($this->getDataBase());
        return $manager->countProduct();
    }
    
    function listToLi($products){
            $ul = "<ul>";
        foreach($products as $product) {
            $li = "<li>";
            $li .= $product->getId()." ";
            $li .= $this->getFamily($product->getIdfamily())." ";
            $li .= $product->getProduct()." ";
            $li .= $product->getPrice()." ";
            $li .= $product->getDescription()." ";
            $li .= '<button class="btnEdit" data-id="'.$product->getId().'"> Edit </a>';//
            $li .= '<button class="btnDelete" data-id="'.$product->getId().'"> Delete </a></li>';//
            $ul .= $li;
        }
            $ul .= "</ul>";
        return $ul;
    }
    
    function insertProduct(Product $product){
        $manager = new ManagerProduct($this->getDataBase());
        $res = $manager->add($product);
        return $res;
    }
}