<?php 

class ManagerMember implements Manager{
    
    private $db;
    
    function __construct(DataBase $db){
        $this->db = $db;
    }
    
    function add($objeto){
        $sql = 'insert into member(login, clave) values (:login, :clave)';
        $params = array(
            'login' => $objeto->getLogin(),
            'clave' => Util::codificar($objeto->getClave(), 10)
        );
        
        $res = $this->db->execute($sql , $params);
        
        if($res){
            $id = $this->db->getId();
            $objeto->setId($id);
        }else{
            $id = 0;
        }
        
        return $id;
    }
    
    function edit($objeto){
        //update member set login = 'jose' where id = 2 and login = (SELECT login FROM member WHERE id = 2);
        $sql = 'update member set login = :login, clave = :clave where id = :id';
        $params = array(
            'login' => $objeto->getLogin(),
            'clave' => Util::codificar($objeto->getClave(), 10),
            'id' => $objeto->getId()
        );
        
        $res = $this->db->execute($sql , $params);
        
        return $res;
    }
    
    function editWithoutPass($objeto){
        $sql = 'update member set login = :login where id = :id';
        $params = array(
            'login' => $objeto->getLogin(),
            'id' => $objeto->getId()
        );
        
        $res = $this->db->execute($sql , $params);
        
        return $res;
    }
    
    function get($id){
        $sql = 'select * from member where id = :id';
        $params = array('id' => $id);
        $res = $this->db->execute($sql , $params);
        $sentencia = $this->db->getStatement();
        $member = new Member();
        if($res && $fila = $sentencia->fetch()){
            $member->set($fila);
        }else{
            $member = null;
        }
        return $member;
    }
    
    function getWithLogin($login){
        $sql = 'select * from member where login = :login';
        $params = array('login' => $login);
        $res = $this->db->execute($sql , $params);
        $sentencia =$this->db->getStatement();
        $member = new Member();
        if($res && $fila = $sentencia->fetch()){
            $member->set($fila);
        }else{
            $member = null;
        }
        return $member;
    }
    
    function getAll(){
        $sql = 'select * from member';
        $res = $this->db->execute($sql);
        $members = array();
        if($res){
            $sentencia =$this->db->getStatement();
            while($fila = $sentencia->fetch()){
                $member = new Member();
                $member->set($fila);
                $members [] = $member;
            }
        }
        return $members;
    }
    
    function getAllLimit($a, $b){
        $sql = 'select * from member limit :a , :b;';
        $params = array(
            'a' => array($a, PDO::PARAM_INT),
            'b' => array($b, PDO::PARAM_INT)
        );
        $res = $this->db->execute($sql, $params);
        $members = array();
        if($res){
            $sentencia = $this->db->getStatement();
            while($fila = $sentencia->fetch()){
                $member = new Member();
                $member->set($fila);
                $members[] = $member;
            }
        }
        return $members;
    }
    
    function getAllCount(){
        $sql = 'select count(*) from member';
        $res = $this->db->execute($sql);
        if($res){
            $sentencia = $this->db->getStatement();
            $fila = $sentencia->fetch();
            return $fila[0];       
        }
        return $res;
    }
    
    function remove($id){
        $sql = 'delete from member WHERE id = :id';
        $params = array ('id' => $id);
        $res = $this->db->execute($sql , $params);
        
        return $res;
    }
    
}