<?php

class Client {
    
    use Utilidades;

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
}
