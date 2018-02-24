<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Según algo que dijo Carmelo sobre Ajax esta cabecera puede dar problemas.
header('Content-Type: text/html; charset=utf-8');
require 'classes/AutoLoad.php';

// $ruta = Request::read("ruta");
// $accion = Request::read("accion");

$accion = '';
$ruta = '';
$urlParams = Request::read('urlparams');
$parametros = explode('/', $urlParams);
if(isset($parametros[0])) {
    $ruta = $parametros[0];
}
if(isset($parametros[1])) {
    $accion = $parametros[1];
}

$frontController = new ControladorFrontal($ruta);

$frontController->doAction($accion);

echo $frontController->doOutput($accion);
?>