<?php

class ManagerProduct{
    
    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    public function add(Product $product){
        $sql = 'insert into product(idfamily, product, price, description) values (:idfamily, :product, :price, :description)';
        $params = array(
            'idfamily' => $product->getIdFamily(),
            'product' => $product->getProduct(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription(),
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $id = $this->db->getId();
            $product->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    
    public function edit(Product $product){
        $sql = 'update product set idfamily = :idfamily , product = :product , price = :price , description = :description where id = :id';
        $params = array(
            'id' => $product->getId(),
            'idfamily' => $product->getIdfamily(),
            'product' => $product->getProduct(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription()
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $rows = $this->db->getRowNumber();
        } else {
            $rows = -1;
        }
        return $rows;
    }
    
    public function get($id){
        $sql = 'select * from product where id = :id';
        $params = array(
            'id' => $id
        );
        $result = $this->db->execute($sql, $params);//true o false
        $statement = $this->db->getStatement();
        $product = new Product();
        if($result && $row = $statement->fetch()) {
            $product->set($row);
        } else {
            $product = null;
        }
        return $product;
    }
    
    public function getAll($idfamily, $text, $page, $limit = 9){
        if ($idfamily > 0 || $text !== '' || $page > 0){
            $sql = 'select * from product';
            $params = array();
            if ($idfamily > 0){
                $sql .= ' where idfamily = :idfamily ';
                $params['idfamily'] = $idfamily;
            }
            if ($text !== ''){
                $sql .= ' where product LIKE :text or description LIKE :text ';
                $params['text'] = '%'.$text.'%';
            }
            if (strpos($sql, 'where') == false) {
                $sql .= ' where 1';
            }
            $sql .= ' and product is not null and product <> "" and description is not null ORDER BY id DESC ';
            if ($page > 0){
                $sql .= ' limit :page , :limit';
                $params['page'] = array(intval($page), PDO::PARAM_INT);
                $params['limit'] = array(intval($limit), PDO::PARAM_INT);
            }
            // SELECT *  FROM `product` WHERE `idfamily` = 2 AND ( `product` LIKE '%mini%' OR `description` LIKE '%mini%' )
            $result = $this->db->execute($sql, $params);
        }else {
            $sql = 'select * from product where 1 and product is not null and product <> "" 
            and description is not null order by id desc limit 0, :limit';
            $params = array(
                'limit' => array(intval($limit), PDO::PARAM_INT));
            $result = $this->db->execute($sql, $params);
        }
        $objects = array();
        if($result){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                //echo Util::varDump($row);
                if($row[2] !== ''){
                    
                }
                $object = new Product();
                $object->set($row);
                $objects[] = $object;
            }
        }
        return $objects;
    }
    
    function getAllFromWP($a, $b){
        $sql = 'SELECT * FROM product p JOIN family f ON p.idfamily = f.id where product <> "" LIMIT :a , :b;';
        $params = array(
            'a' => array($a, PDO::PARAM_INT), 
            'b' => array($b, PDO::PARAM_INT), 
        );
        
        $res = $this->db->execute($sql , $params);
        $statement = $this->db->getStatement();
        $join = array();
        
        if($res){
            while($row = $statement->fetch()){
                if($row[2] !== ''){
                    $join[] = array(
                        'id' => $row[0],
                        'product' => $row[2],
                        'price' => $row[3],
                        'description' => $row[4],
                        'family' => $row[6],
                    ); 
                }   
            }
        }
        
        return $join;
    }
    
    function countProduct(){
        $sql = 'Select count(*) from product where product <> "" or product';
        
        $res = $this->db->execute($sql);
        $statement = $this->db->getStatement();
        
        $count = 0;
        
        if($res && $row = $statement->fetch()){
            $count = $row[0];
        }
        
        return $count;
    }
    
    public function remove($id){
        $sql = 'update product set product = :product , description = :description where id = :id';
        $params = array(
            'id' => $id,
            'product' => null,
            'description' => null
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $rows = $this->db->getRowNumber();
        } else {
            $rows = -1;
        }
        return $rows;
    }
}