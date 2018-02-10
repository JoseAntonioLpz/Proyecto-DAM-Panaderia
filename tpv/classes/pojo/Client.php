<?php

class Client {

    private $id, $name, $surname, $tin, $address, $location, $postalcode, $province, $email;

    function __construct($id = null, $name = null, $surname = null, $tin = null, $address = null, $location = null, $postalcode = null, $province = null, $email = null) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->tin = $tin;
        $this->address = $address;
        $this->location = $location;
        $this->postalcode = $postalcode;
        $this->province = $province;
        $this->email = $email;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSurname() {
        return $this->surname;
    }

    function getTin() {
        return $this->tin;
    }

    function getAddress() {
        return $this->address;
    }

    function getLocation() {
        return $this->location;
    }

    function getPostalcode() {
        return $this->postalcode;
    }

    function getProvince() {
        return $this->province;
    }

    function getEmail() {
        return $this->email;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSurname($surname) {
        $this->surname = $surname;
    }

    function setTin($tin) {
        $this->tin = $tin;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setPostalcode($postalcode) {
        $this->postalcode = $postalcode;
    }

    function setProvince($province) {
        $this->province = $province;
    }

    function setEmail($email) {
        $this->email = $email;
    }


    function getAttributes() {
        $atributos = [];
        foreach ($this as $atributo => $valor) {
            $atributos[] = $atributo;
        }
        return $atributos;
    }

    function getValues() {
        $valores = [];
        foreach ($this as $valor) {
            $valores[] = $valor;
        }
        return $valores;
    }

    function getAttributesValues() {
        $valoresCompletos = [];
        foreach ($this as $atributo => $valor) {
            $valoresCompletos[$atributo] = $valor;
        }
        return $valoresCompletos;
    }

    function read() {
        foreach ($this as $atributo => $valor) {
            $this->$atributo = Request::read($atributo);
        }
    }

    function set(array $array, $pos = 0) {
        foreach ($this as $campo => $valor) {
            if (isset($array[$pos])) {
                $this->$campo = $array[$pos];
            }
            $pos++;
        }
    }

    function setFromAssociative(array $array) {
        foreach ($this as $indice => $valor) {
            if (isset($array[$indice])) {
                $this->$indice = $array[$indice];
            }
        }
    }

    public function __toString() {
        $cadena = get_class() . ': ';
        foreach ($this as $atributo => $valor) {
            $cadena .= $atributo . ': ' . $valor . ', ';
        }
        return substr($cadena, 0, -2);
    }

}
