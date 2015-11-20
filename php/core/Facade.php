<?php

require_once "php/factories/DBFactory.php";
require_once "php/factories/ChatFactory.php";
require_once "php/factories/OperationsFactory.php";
require_once "php/data/InMemoryDatabase.php";
require_once "php/data/MySqlDatabase.php";
require_once "php/data/ChatDb.php";
require_once "php/interfaces/IDatabase.php";
require_once "php/interfaces/IChatDatabase.php";

class Facade{

    // Class variables

    private $database, $chatDatabase, $operations;

    public function __construct(){
        
        $this->database = DBFactory::createDatabase("mysql");
        $this->chatDatabase = DBFactory::createChatDatabase("mysql");
        $this->operations = OperationsFactory::createOperations();
    }

    public function login($username,$password){
        return $this->database->login($username,$this->encryptPassword($username, $password));
    }
 
    public function addAccount($username, $password, $firstname){
        return $this->database->addAccount($username, $this->encryptPassword($username, $password), $firstname);
    }

    public function getFriends($username){
        return $this->database->getFriends($username);
    }

    public function retrieveChat($user1, $user2){
        $username = $user1->getUsername();
        return $this->chatDatabase->retrieveChat($username, $user2);
    }

    public function storeChat($user1,$user2){
        $username = $user1->getUsername();
        return $this->chatDatabase->storeChat($username, $user2);
        //return $this->chatDatabase->storeChat($chat);
    }

    public function saveMessage($chatID, $message){
        $this->chatDatabase->saveMessage($chatID,$message);
    }


    public function getMessages($chatID){
        return $this->chatDatabase->getMessages($chatID);
    }

    public function encryptPassword($username, $password){
        return $this->operations->encryptPassword($username, $password);
    }

    public function logout(){
        return $this->database->logout();
    }

    public function changePass($username, $newPassword){
        return $this->database->updatePassword($username, $this->encryptPassword($username, $newPassword));
    }
}