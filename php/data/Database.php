<?php

/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 07/09/2015
 * Time: 18:16
 */


class Database
{

    protected $servername, $username, $dbname, $password, $con;

    public function __construct(){
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "chat";
    }



    public function dbConnect(){
        try{
            $this->con = new PDO("mysql:host=".$this->servername."; dbname=".$this->dbname,$this->username,$this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $ex){
            echo "Connection failed " . $ex->getMessage();
        }
    }

    public function dbClose(){
        $this->con = null;
    }
}