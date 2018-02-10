<?php

class ModeloProduct extends Modelo {
    
    function getAllProducts($idfamily, $text, $page){
        // $array = array();
        // /* Datos de prueba */
        // $array[] = new Product(1, 1, "Bread", 0.80, "Very tasty.");
        // $array[] = new Product(2, 1, "Garlic Bread", 1.00, "I don't know what it's made of.");
        // $array[] = new Product(3, 2, "Hard Bread", 0.20, "From yesterday.");
        // $array[] = new Product(4, 1, "Raw Bread", 0.10, "It's just flour.");
        // // ----------------
        $manager = new ManagerProduct($this->getDataBase());
        $array = $manager->getAll($idfamily, $text, $page);
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
    
    function getAllProductsJson($idfamily, $text, $page){
        $products = $this->getAllProducts($idfamily, $text, $page);
        $json = array();
        foreach($products as $product) {
            $product->setIdfamily($this->getFamily($product->getIdfamily()));
            $json[] = $product->getAttributesValues();
        }
        return $json;
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