<?php

class ControladorClient extends Controlador{
    
    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function index(){
        if($this->isLogged()){
            
            //paginacion
            $rows = $this->getModel()->getRows();
            $page = Request::read('page');//página actual
            if($page === null) {
                $page = 1;
            }
    
            $pagination = new Pagination($rows,$page,3);
            
            $rpp = $pagination->getRpp();
            $offset = $pagination->getOffset();
            
            $sig = $pagination->getNext();
            $ant = $pagination->getPrevious();
            //pagination
            
            
            
            //comprobaciones
            $op = Request::read('op');
            $res = request::read('res');
            $this->getModel()->setDato('mensaje', $op . ' ' . $res);
            
            
            //$this->getModel()->setDato('archivo', 'templates/client/_client_list.html');
            $html = Util::includeTemplates('templates/client/_client_list.html');
            $this->getModel()->setDato('archivo' , $html);
            
            $trClient = '<tr>
                            <td>{{name}}</td>
                            <td>{{tin}}</td>
                            <td>{{address}}</td>
                            <td>{{postalcode}} {{location}}</td>
                            <td>{{province}}</td>
                            <td>
                                <div class="actions">
                                        <a class="bt-action edit" href="?ruta=client&accion=edit_client_template&idClient={{id}}"><i class="fa fa-pencil-square-o"></i></a>
                                        <a class="bt-action remove remove-client" href="?ruta=client&accion=remove_client&idClient={{id}}"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                         </tr>';
            //$clients = $this->getModel()->getAll();
            $clients = $this->getModel()->getAllLimit($offset, $rpp);
            $tableClients = '';
            foreach($clients as $key => $client) {
                $r = Util::renderText($trClient, $client->getAttributesValues());  //sustituir placeholders de $trClient por los datos de los clientes
                $tableClients .= $r;                                                // y vamos almacenando cada linea en $tableClients
            }
            $this->getModel()->setDato('client-list', $tableClients);
            
            //paginacion
            $btNext = '
                                <a href="?ruta=client&page=' . $sig . '">Next</a>
                       ';
            $btPrev = '
                                <a href="?ruta=client&page=' . $ant . '">Prev</a>
                       ';
            $this->getModel()->setDato('next',$btNext);
            $this->getModel()->setDato('prev',$btPrev);
            $rango = $pagination->getRange();
            $todo2 = '';
            foreach($rango as $pagina){
                    $btPagina = '
                                    <a href="index.php?ruta=client&page=' . $pagina . '">' . $pagina . '</a>
                                 ';
                    if($pagina == $page){
                       $btPagina = '
                                        <a class="active" href="index.php?ruta=client&page=' . $pagina . '">' . $pagina . '</a>
                                    '; 
                    }
                    
                    $todo2 .= $btPagina;
            }
            $this->getModel()->setDato('pagination', $todo2);
        }else{
            $this->getModel()->setDato('archivo', 'templates/first_page.html');
        }
    }
    
    //función que te lleva a la plantilla de insertar nuevo cliente
    function insert_client_template(){
        if($this->isLogged()){
            //$this->getModel()->setDato('archivo','templates/client/_insert_client.html');
            $html = Util::includeTemplates('templates/client/_insert_client.html');
            $this->getModel()->setDato('archivo' , $html);
        }else{
            $this->index();
        }
    }
    
    //función que inserta un cliente nuevo
    function insert_client(){
        if($this->isLogged()){
            $client = new Client();
            $client->read();
            //echo Util::varDump($client);
            $r = -1;
            if(Filter::isEmail($client->getEmail()) && Filter::isNumber($client->getPostalcode())){
                $r = $this->getModel()->insertClientBD($client);
                //$r = $client;
                echo $r;
            }
            
            header('Location: ?ruta=client&op=insertarCliente&res=' . $r);
            exit();
        }else{
            $this->index();
        }
    }
    
    //insertar varios clientes del tirón
    function insert_various_clients(){
        if($this->isLogged()){
            $names = Request::read('name');
            $surnames = Request::read('surname');
            $tins = Request::read('tin');
            $addresses = Request::read('address');
            $locations = Request::read('location');
            $postalcodes = Request::read('postalcode');
            $provinces = Request::read('province');
            $emails = Request::read('email');
            $res = 0;
            for ($i = 0; $i < count($names) ; $i++){
                $client = new Client(null, $names[$i], $surnames[$i], $tins[$i], $addresses[$i], $locations[$i], $postalcodes[$i], $provinces[$i], $emails[$i]);
                $res .= $this->getModel()->insertClientBD($client);
            }
            
            header('Location: ?ruta=client&op=insertarClientes&res=' . $r);
            exit();
        }else{
            $this->index();
        }
    }
    
    function remove_client(){//falta hacer confirmación con javascript
        $r = -2;
        if($this->isLogged()){
            $client = $this->getModel()->getClient(Request::read('idClient'));
            if($client !== null){
                $r = $this->getModel()->removeClientBD($client->getId());
            }
            header('Location: ?ruta=client&op=borrarCliente&res=' . $r);
            exit();
        }else{
            $this->index();
        }
    }
    
    function edit_client_template(){
        if($this->isLogged()){
            $this->getModel()->setDato('archivo',Util::includeTemplates('templates/client/_edit_client.html'));
            $client = $this->getModel()->getClient(Request::read('idClient'));
            $client = $client->getAttributesValues();
            foreach($client as $atributo => $valor){
                $this->getModel()->setDato($atributo,$valor);
            }
        }else{
            $this->index();
        }
    }
    
    function edit_client(){
        if($this->isLogged()){
            $clientEdit = new Client();
            $clientEdit->read();
            $r = $this->getModel()->editClient($clientEdit);
            header('Location: ?ruta=client&op=editarCliente&res=' . $r);
            exit();
        }else{
            $this->index();
        }
    }
    
    //obtener cliente para ajax(clientes en forma de array)
    function get_clients_ajax(){
        if($this->isLogged()){
            $clientes = $this->getModel()->getAllAjax();
            $this->getModel()->setDato('clients',$clientes);
        }else{
            $this->index();
        }
    }
    
}