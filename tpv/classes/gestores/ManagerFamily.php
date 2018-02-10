<?php

class ManagerFamily implements Manager{
    
    private $db;
    
    function __construct(DataBase $db){
        $this->db = $db;
    }
    
    function add($objeto){}
    
    function edit($objeto){}
    
    function get($id){
        $sql = 'select * from family where id = :id';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $sentencia = $this->db->getStatement();
        $family = new Family();
        
        if($res && $fila = $sentencia->fetch()){
            $family->set($fila);
        }else{
            $family = null;
        }
        
        return $family;
    }
    
    function getAll(){
        $sql = 'select * from family';
        
        $res = $this->db->execute($sql);
        $sentencia = $this->db->getStatement();
        $familys = array();
        
        if($res){
            while($fila = $sentencia->fetch()){
                $family = new Family();
                $family->set($fila);
                $familys[] = $family->getAttributesValues();
            }
        }else{
            $familys = null;
        }
        
        return $familys;
    }
    
    function remove($id){}
}