<?php


class Account{
    
    private $username, $password, $firstname;
    
    public function __construct(){}

    public function setUsername($username){
        $this->username = $username;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setFirstname($firstname){
        $this->firstname = $firstname;
    }

    public function getUsername(){return $this->username;}
    public function getPassword(){return $this->password;}
    public function getFirstname(){return $this->firstname;}



}



?>