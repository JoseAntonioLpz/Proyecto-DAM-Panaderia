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
    
    public function getAll($idfamily, $text, $page){
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
            $sql .= ' and product is not null and product != "" and description is not null and description != "" ORDER BY id DESC ';
            if ($page > 0){
                $sql .= ' limit '.$page.' , 9';
                // $params['page'] = array($page, PDO::PARAM_INT);
            }
            // SELECT *  FROM `product` WHERE `idfamily` = 2 AND ( `product` LIKE '%mini%' OR `description` LIKE '%mini%' )
            $result = $this->db->execute($sql, $params);
        }else {
            $sql = 'select * from product where 1 and product is not null and product != "" 
            and description is not null and description != "" order by id desc limit 0, 9';
            $result = $this->db->execute($sql);
        }
        $objects = array();
        if($result){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $object = new Product();
                $object->set($row);
                $objects[] = $object;
            }
        }
        return $objects;
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