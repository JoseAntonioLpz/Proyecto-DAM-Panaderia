<?php

class ManagerMix implements Manager{
    
    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    function add($objeto){}
    
    function edit($objeto){}
    
    function get($id){}
    
    function getAll(){
        return array(
            'product' => $this->getCountProducts(),
            'member' => $this->getCountMember(),
            'client' => $this->getCountClient()
        );
    }
    
    function remove($id){}
    
    function getCountProducts(){
        $sql = "SELECT count( * ) FROM product WHERE NOT product = '';";
        $res = $this->db->execute($sql);
        $statement = $this->db->getStatement();
        $count = null;
        
        if($res && $row = $statement->fetch()){
            $count = $row[0];
        }
        
        return $count;
    }
    
    function getCountMember(){
        $sql = "SELECT count( * ) FROM member;";
        $res = $this->db->execute($sql);
        $statement = $this->db->getStatement();
        $count = null;
        
        if($res && $row = $statement->fetch()){
            $count = $row[0];
        }
        
        return $count;
    }
    
    function getCountClient(){
        $sql = "SELECT count( * ) FROM client;";
        $res = $this->db->execute($sql);
        $statement = $this->db->getStatement();
        $count = null;
        
        if($res && $row = $statement->fetch()){
            $count = $row[0];
        }
        
        return $count;
    }
}