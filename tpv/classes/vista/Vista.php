<?php

class Vista {
    
    private $modelo;
    
    function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }

    function getModel(){
        return $this->modelo;
    }

    private function index() {
        $datos = $this->getModel()->getDatos();
        $archivo = $datos['archivo'];
        return Util::renderText($archivo, $datos);
    }

    function render($accion) {
        if(!method_exists(get_class(), $accion)) {
            $accion = 'index';
        }
        return $this->$accion();
    }
}