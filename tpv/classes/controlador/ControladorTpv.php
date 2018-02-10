<?php

class ControladorTpv extends Controlador{
    
    function index(){
        if($this->isLogged()){
            //$this->getModel()->setDato('id_member' , $this->getUser()->getId());
            $html = Util::includeTemplates('templates/tpv/_tpv.html');
            $this->getModel()->setDato('archivo' , $html);
        }else{
            header('Location: index.php');
        }
    }
}