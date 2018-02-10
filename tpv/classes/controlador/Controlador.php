<?php

/* vamos a dejarlo con sólo los métodos comunes a todos */

class Controlador {

    private $modelo;
    private $sesion;

    function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
        $this->sesion = new Session(Constant::SESSION);
        if($this->isLogged()) {
            $usuario = $this->getUser();
            $this->getModel()->setDato('usuario', $usuario->getLogin());
            if(isset($_SESSION['idTicket'])){
                $this->getModel()->setDato('idTicket', $this->sesion->get('idTicket'));
            }
        }
    }

    function getModel() {
        return $this->modelo;
    }

    function getSession() {
        return $this->sesion;
    }

    function getUser() {
        return $this->getSession()->getUser();
    }

    function isLogged() {
        return $this->getSession()->isLogged();
    }
    
    function isBlocked($block = null){
        return $this->getSession()->isBlocked($block);
    }
    
    // Sobreescribir este método en todos los herederos
    function index(){
        if($this->isLogged()){
            $archivo = Util::includeTemplates('templates/home_loged.html');
            if($this->getUser()->getId() == '1'){
                $archivo = Util::includeTemplates('templates/home_loged_admin.html');
            }
            $this->getModel()->setDato('archivo' , $archivo);
        }else{
            $archivo = Util::includeTemplates('templates/first_page.html');
            $this->getModel()->setDato('archivo' , $archivo);
        }
    }
    
    function addCarro(){ //En Construccion XD
        if($this->isLogged()){
            $id_product = Request::read('id');
            $cantidad = Request::read('cantidad');
            if($cantidad == null){
                $cantidad = 1;
            }
            $this->getSession()->set('idTicket', Request::read('idTicket'));
            
            $product = $this->getModel()->getProduct($id_product);
            
            //echo Util::varDump($product);
            //exit;
            $carro = $this->getSession()->getCarro();
            $carro->add($product->getId() , $product->getAttributesValues(), $cantidad);
            $this->getModel()->setDato('data' , $carro->getCarrito());
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    function subCarro(){
        if($this->isLogged()){
            $id_product = Request::read('id');
            $this->getSession()->set('idTicket', Request::read('idTicket'));
            
            $product = $this->getModel()->getProduct($id_product);
            
            //echo Util::varDump($product);
            //exit;
            $carro = $this->getSession()->getCarro();
            $carro->sub($product->getId() , $product->getAttributesValues(), $cantidad = 1);
            $this->getModel()->setDato('data' , $carro->getCarrito());
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    function removeCarro(){
        if($this->isLogged()){
            $id_product = Request::read('id');
            $this->getSession()->set('idTicket', Request::read('idTicket'));
            
            $product = $this->getModel()->getProduct($id_product);
            
            //echo Util::varDump($product);
            //exit;
            $carro = $this->getSession()->getCarro();
            /*$carro->del($product->getId());*/
            
            $carro->del($id_product);
            $this->getModel()->setDato('data' , $carro->getCarrito());
        }else{
            $this->getModel()->setDato('data' , '');
        }
    }
    
    function verCarro(){ 
        $carro = $this->getSession()->getCarro();
        $this->getModel()->setDato('data' , $carro->getCarrito());
    }
    
    function reiniciarCarro(){
        $this->getSession()->setCarro();
        $carro = $this->getSession()->getCarro();
        $this->getModel()->setDato('data' , $carro->getCarrito());
    }
}