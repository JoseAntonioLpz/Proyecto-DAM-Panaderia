<?php

class Util{
    
    static function varDump($valor){ //método para hacer un var_dump de forma más bonita
        return '<pre>' . var_export($valor, true) . '</pre>';
    }
    
    static function selector($array =  array() , $name){
        $cadena = '<select name="' . $name . '">';
        for($i = 0; $i < count($array); $i++){
            $cadena .= '<option value="' . $array[$i][0] . '">' . $array[$i][1] . '</option>';
        }
        $cadena .= '</select>';
        return $cadena;
    }
    
    static function codificar($palabra, $coste = 10){
        $opciones = array(
            'cost' => $coste 
        );
        return password_hash($palabra, PASSWORD_DEFAULT, $opciones);
    }
    
    static function validarCodificacion($palabra, $codificado){
        return password_verify($palabra, $codificado);
    }
    
    static function enviarCorreo ($destino, $asunto, $mensaje) {
        require_once 'classes/vendor/autoload.php';
        $cliente = new Google_Client();
        $cliente->setApplicationName(Constant::APPNAME);
        $cliente->setClientId(Constant::CLIENTID);
        $cliente->setClientSecret(Constant::CLIENTSECRET);
        $cliente->setAccessType('offline');
        $cliente->setAccessToken(file_get_contents(Constant::TOKEN));
        if ($cliente->getAccessToken()) {
            $service = new Google_Service_Gmail($cliente);
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->CharSet = "UTF-8";
                $mail->From = Constant::CORREO;
                $mail->FromName = Constant::ALIAS;
                $mail->AddAddress($destino);
                $mail->AddReplyTo(Constant::CORREO, Constant::ALIAS);
                $mail->Subject = $asunto;
                $mail->Body = $mensaje;
                $mail->IsHTML(true);
                $mail->preSend();
                $mime = $mail->getSentMIMEMessage();
                $mime = rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
                $mensaje = new Google_Service_Gmail_Message();
                $mensaje->setRaw($mime);
                $service->users_messages->send('me', $mensaje);
                return true;
            } catch (Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }
    
    static function renderTemplate($template, array $data = array()) {
        if (!file_exists($template)) {
            return '';
        }
        $content = file_get_contents($template);
        return self::renderText($content, $data);
    }

    static function renderText($text, array $data = array()) {
        foreach ($data as $indice => $dato) {
            $text = str_replace('{{' . $indice . '}}', $dato, $text);
        }
        //quitar los {{...}} restantes
        $text = preg_replace('/{{[^\s]+}}/', '', $text);
        return $text;
    }
    
    static function includeTemplates($template){
        $html = '';
        $array = array(
                'templates/includes/head.html',
                $template
        );
        
        foreach($array as $template){
            if(file_exists($template)){
                $html .= file_get_contents($template);
            }
        }
        return $html;
    }
}