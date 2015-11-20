<?php

//This is the misc file with operational methods such as password encryption etc.
class Operations{

    public function encryptPassword($username, $password){

        //Filler to solidify the encryption a bit
        $middle = "-_*";

        //Full encryption key
        $toEncrypt = $username . $middle . $password;

        $encrypted = sha1($toEncrypt);

        return $encrypted;
    }
}