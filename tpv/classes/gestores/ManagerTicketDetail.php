<?php

class ManagerTicketDetail implements Manager{
    
    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    function add($ticketDetail){
        $sql = 'insert into ticketdetail (idticket, idproduct, quantity, price) values (:idticket, :idproduct, :quantity, :price)';
        $params = array(
                'idticket' => $ticketDetail->getIdticket(),
                'idproduct' => $ticketDetail->getIdproduct(),
                'quantity' => $ticketDetail->getQuantity(),
                'price' => $ticketDetail->getPrice()
            );
        $result = $this->db->execute($sql, $params);
        //echo Util::varDump($params);
        if($result) {
            $id = $this->db->getId();
            $ticketDetail->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    
    
    function edit($ticketDetail){
        
    }
    
    function get($id){
        
    }
    
    function getJoinWithProduct($id){
        $sql = 'SELECT td.id, td.price, td.quantity, pr.product FROM ticketdetail td join product pr on pr.id = td.idproduct WHERE td.idticket = :id;';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $sentencia = $this->db->getStatement();
        $detalles = array();
        
        if($res){
            while($fila = $sentencia->fetch()){
                $detalles [] = array(
                    'id' => $fila[0], 	
                    'price' => $fila[1],	
                    'quantity' => $fila[2],
                    'product' => $fila[3]
                );
            }
        }
        return $detalles;
    }
    
    function getTicketIdWithIdDetails($id){
        $sql = 'SELECT idticket from ticketdetail where id = :id;';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        $sentencia = $this->db->getStatement();
        
        if($res && $fila = $sentencia->fetch()){
            return $fila[0];
        }
        
        return 0;
    }
    
    function getAll(){
        
    }
    
    function remove($id){
        $idTicket = $this->getTicketIdWithIdDetails($id);
        $sql = 'DELETE FROM ticketdetail WHERE id = :id';
        $params = array('id' => $id);
        
        $res = $this->db->execute($sql, $params);
        
        if($res){
            return array('res' => 1, 'idTicket' => $idTicket);
        }
        return 0;
    }
    
}