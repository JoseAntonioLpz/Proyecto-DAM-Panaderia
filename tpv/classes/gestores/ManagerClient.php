<?php

class ManagerClient implements Manager{
    
    private $db;

    function __construct(DataBase $db) {
        $this->db = $db;
    }
    
    function add($client){
        $sql = 'insert into client (name, surname, tin, address, location, postalcode, province, email)
            values (:name, :surname, :tin, :address, :location, :postalcode, :province, :email)';
            
        /*
            INSERT INTO `client`(`id`, `name`, `surname`, `tin`, `address`, `location`, `postalcode`, `province`, `email`) 
            VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])
        */    
        $params = array(
            'name' => $client->getName(),
            'surname' => $client->getSurname(),
            'tin' => $client->getTin(),
            'address' => $client->getAddress(),
            'location' => $client->getLocation(),
            'postalcode' => $client->getPostalcode(),
            'province' => $client->getProvince(),
            'email' => $client->getEmail()
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $id = $this->db->getId();
            $client->setId($id);
        } else {
            $id = 0;
        }
        return $id;
    }
    
    function edit($client){
        $sql = 'update client set name = :name, surname = :surname, tin = :tin, address = :address, location = :location, postalcode = :postalcode, province = :province, email = :email where id = :id';
        $params = array(
            'name' => $client->getName(),
            'surname' => $client->getSurname(),
            'tin' => $client->getTin(),
            'address' => $client->getAddress(),
            'location' => $client->getLocation(),
            'postalcode' => $client->getPostalcode(),
            'province' => $client->getProvince(),
            'email' => $client->getEmail(),
            'id' => $client->getId()
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
    function get($id){
        $sql = 'select * from client where id = :id';
        $params = array(
            'id' => $id
        );
        $result = $this->db->execute($sql, $params);//true o false
        $statement = $this->db->getStatement();
        $client = new Client();
        if($result && $row = $statement->fetch()) {
            $client->set($row);
        } else {
            $client = null;
        }
        return $client;
    }
    
    function getAll(){
        $sql = 'select * from client where 1';
        $result = $this->db->execute($sql);
        $clients = array();
        if($result){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $client = new Client();
                $client->set($row);
                $clients[] = $client;
            }
        }
        return $clients;
    }
    
    function getAllAjax(){
        $sql = 'select * from client where 1';
        $result = $this->db->execute($sql);
        $clients = array();
        if($result){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $client = new Client();
                $client->set($row);
                $clients[] = $client->getAttributesValues();
            }
        }
        return $clients;
    }
    
    function getAlllimit($offset, $rpp) {
        $sql = 'select * from client limit '. $offset . ', ' . $rpp;
        $result = $this->db->execute($sql);
        $clients = array();
        if($result){
            $statement = $this->db->getStatement();
            while($row = $statement->fetch()) {
                $client = new Client();
                $client->set($row);
                $clients[] = $client;
            }
        }
        return $clients;
    }
    
    function count(){
        $sql = 'select count(*) from client';
        $res = $this->db->execute($sql);
        $cuenta = 0;
        if($res) {
            $sentencia = $this->db->getStatement();
            if($fila = $sentencia->fetch()) {
                $cuenta = $fila[0];
            }
        }
        return $cuenta;
    }
    
    function remove($id){
        $sql = 'delete from client where id = :id';
        $params = array(
            'id' => $id
        );
        $result = $this->db->execute($sql, $params);
        if($result) {
            $affectedRows = $this->db->getRowNumber();
        } else {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
}