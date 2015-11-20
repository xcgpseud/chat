<?php

/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 28/08/2015
 * Time: 18:45
 */

require_once "php/data/MySqlChatDatabase.php";
class DBFactory{

    public static function createDatabase($dbType){
        if($dbType == "mysql"){
            return new MySqlDatabase();
        }elseif($dbType == "offline"){
            return InMemoryDatabase::getDatabase();
        }
    }

    public static function createChatDatabase($dbType){
        if($dbType == "mysql"){
            return new MySQLChatDatabase();
        }elseif($dbType == "offline"){
            return new ChatDb();
        }
    }
}



?>