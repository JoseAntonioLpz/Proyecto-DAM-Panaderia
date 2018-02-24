<?php

class ManagerTicket implements Manager{
    
    private $db;
    
    function __construct(DataBase $db){
        $this->db = $db;
    }
    
    function add($objeto){
        $sql = 'insert into ticket (date, idmember, idclient) values(:date, :idmember, :idclient)';
        $params = array(
            'date' => $objeto->getDate(),
            'idmember' => $objeto->getIdMember(),
            'idclient' => $objeto->getIdClient()
        );
        
        $res = $this->db->execute($sql, $params);
        
        if($res){
            $id = $this->db->getId();
        }else{
            $id = 0;
        }
        
        return $id;
    }
    
    function edit($objeto){}
    
    //editar solo el idcliente del ticket
    function editTicketIdClient($ticket){
        $sql = 'update ticket set idclient = :idclient where id = :id';
        $params = array(
            'idclient' => $ticket->getIdClient(),
            'id' => $ticket->getId()
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
        $sql = 'select * from ticket where id = :id';
        $params = array(
            'id' => $id
        );
        $result = $this->db->execute($sql, $params);//true o false
        $statement = $this->db->getStatement();
        $ticket = new Ticket();
        if($result && $row = $statement->fetch()) {
            $ticket->set($row);
        } else {
            $ticket = null;
        }
        return $ticket;
    }
    
    function getAll(){ //AJAX
        $sql = 'select * from ticket';
        $res = $this->db->execute($sql);
        $tickets = array();
        $sentencia = $this->db->getStatement();
        
        if($res){
            while($fila = $sentencia->fetch()){
                $ticket = new Ticket();
                $ticket->set($fila);
                $tickets[] = $ticket->getAttributesValues();
            }
        }
        return $tickets;
    }
    
    function getAllJoinMemberAndClient(){
        $sql = 'select t.id, t.date, m.login, c.name, c.surname, c.tin, c.id from ticket t 
        join member m on m.id = t.idmember left join client c on c.id = t.idclient';
        $res = $this->db->execute($sql);
        $join = array();
        $sentencia = $this->db->getStatement();
        
        if($res){
            while($fila = $sentencia->fetch()){
                //echo Util::varDump($fila);
                $join[] = array(
                    'id' => $fila[0],
                    'date' => $fila[1],
                    'login' => $fila[2],
                    'name' => $fila[3],
                    'surname' => $fila[4],
                    'tin' => $fila[5],
                    'id_client' => $fila[6]
                );
            }
        }
        return $join;
    }
    
    function getAllJoinMemberAndClientLimit($a, $b, $order){ //Ajax
    
        $orders=array("t.date", "m.login", "c.surname" ,"c.name", "c.id");
        $key = array_search($order ,$orders);
        $order = $orders[$key];
        $sql = "select t.id, t.date, m.login, c.name, c.surname, c.tin, c.id from ticket t 
        join member m on m.id = t.idmember left join client c on c.id = t.idclient order by $order DESC limit :a , :b;";
        $params = array(
            'a' => array($a, PDO::PARAM_INT),
            'b' => array($b, PDO::PARAM_INT),
            /*'order' => array($order, PDO::PARAM_STR)*/
        );
        $res = $this->db->execute($sql, $params);
        $join = array();
        $sentencia = $this->db->getStatement();
        
        if($res){
            while($fila = $sentencia->fetch()){
                //echo Util::varDump($fila);
                $join[] = array(
                    'id' => $fila[0],
                    'date' => $fila[1],
                    'login' => $fila[2],
                    'name' => $fila[3],
                    'surname' => $fila[4],
                    'tin' => $fila[5],
                    'id_client' => $fila[6]
                );
            }
        }
        return $join;
    }
    
    function getCount(){
        $sql = 'SELECT count(*) from ticket';
        
        $res = $this->db->execute($sql);
        $sentencia = $this->db->getStatement();
        if($res && $fila = $sentencia->fetch()){
            return $fila[0];
        }
        
        return 0;
    }
    
    function remove($id){
        $sql = 'DELETE FROM ticket WHERE id = :id';
        $params = array(
            'id' => $id
        );
        
        $res = $this->db->execute($sql, $params);
        return $res;
    }
    
    function clean(){
        $sql = 'DELETE t FROM ticket t LEFT JOIN ticketdetail td ON t.id=td.idticket WHERE td.idticket IS NULL;';
        $res = $this->db->execute($sql);
        return $res;
    }
    
    function searchDate($criterio){
        $sql = "select t.id, t.date, m.login, c.name, c.surname, c.tin, c.id from ticket t 
        join member m on m.id = t.idmember left join client c on c.id = t.idclient where t.date like :date order by t.date"; //DESC limit :a , :b;";
        $params = array(
            //'a' => array($a, PDO::PARAM_INT),
            //'b' => array($b, PDO::PARAM_INT),
            'date' => '%' . $criterio . '%'
            /*'order' => array($order, PDO::PARAM_STR)*/
        );
        $res = $this->db->execute($sql, $params);
        $join = array();
        $sentencia = $this->db->getStatement();
        
        if($res){
            while($fila = $sentencia->fetch()){
                //echo Util::varDump($fila);
                $join[] = array(
                    'id' => $fila[0],
                    'date' => $fila[1],
                    'login' => $fila[2],
                    'name' => $fila[3],
                    'surname' => $fila[4],
                    'tin' => $fila[5],
                    'id_client' => $fila[6]
                );
            }
        }
        return $join;
    }
    
    function search($criterio){
        $sql = "select t.id, t.date, m.login, c.name, c.surname, c.tin, c.id from ticket t 
        join member m on m.id = t.idmember left join client c on c.id = t.idclient 
        where m.login like :login OR  c.name like :name OR c.surname like :surname OR c.tin like :tin
        order by t.date";
        
        $params = array(
            'login' => '%' . $criterio . '%',
            'name' => '%' . $criterio . '%',
            'surname' => '%' . $criterio . '%',
            'tin' => '%' . $criterio . '%',
        );
        $res = $this->db->execute($sql, $params);
        $join = array();
        $sentencia = $this->db->getStatement();
        
        if($res){
            while($fila = $sentencia->fetch()){
                //echo Util::varDump($fila);
                $join[] = array(
                    'id' => $fila[0],
                    'date' => $fila[1],
                    'login' => $fila[2],
                    'name' => $fila[3],
                    'surname' => $fila[4],
                    'tin' => $fila[5],
                    'id_client' => $fila[6]
                );
            }
        }
        return $join;
    }
    
}