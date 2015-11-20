<?php

/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 05/09/2015
 * Time: 02:08
 */
require_once "php/interfaces/IChatDatabase.php";
require_once "php/data/Database.php";
class MySQLChatDatabase extends Database implements IChatDatabase
{
    public function __construct()
    {
        parent::__construct();
    }

    private function getUserID($username)
    {
        $this->dbConnect();


        $sql = "select id from accounts where username = ?";
        $statement = $this->con->prepare($sql);
        $statement->bindParam(1,$username);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $results = $statement->fetchAll();

        $id = -1;
        foreach($results as $row){
            $id = $row["id"];
        }

        $this->dbClose();

        return $id;
    }

    public function storeChat($user1,$user2)
    {
        $user1ID = $this->getUserID($user1);
        $user2ID = $this->getUserID($user2);

        $this->dbConnect();

        $sql = "INSERT INTO chats(user1, user2) VALUES(?, ?)";

        $statement = $this->con->prepare($sql);
        $statement->bindParam(1, $user1ID);
        $statement->bindParam(2, $user2ID);

        $statement->execute();

        $this->dbClose();
        return $this->retrieveChat($user1,$user2);
    }

    public function retrieveChat($user1, $user2)
    {
        // Find chat where user1 & user1 or user2&user1 match
        // If true
        //  pull chat from db and return chat object (ORM: Object Relational Mapping)
        //  return chat
        // else
        // return null;


        $userID1 = $this->getUserID($user1);
        $userID2 = $this->getUserID($user2);


        $this->dbConnect();
        $sql = "select * from chats where  (user1 = ? and user2 = ?) or (user1 = ? and user2 = ?)";
        //echo $sql;

        $statement = $this->con->prepare($sql);
        $statement->bindParam(1,$userID1);
        $statement->bindParam(2,$userID2);

        $statement->bindParam(4,$userID1);
        $statement->bindParam(3,$userID2);

        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);

        $results = $statement->fetchAll();

        $chat = null;

        foreach($results as $row)
        {
            $chat = new Chat($row["id"], $row["user1"], $row["user2"]);
        }

        $this->dbClose();

        return $chat;

    }

    public function saveMessage($chatID, $message)
    {

        $this->dbConnect();

        $sql = "insert into chatmessage(chatid,chatmessage) values(?,?)";

        $statement = $this->con->prepare($sql);
        $statement->bindParam(1,$chatID);
        $statement->bindParam(2,$message);
        $statement->execute();


        $this->dbClose();
    }

    public function getMessages($chatID)
    {
        $this->dbConnect();

        $sql = "select * from chatmessage where chatid = ?";
        $statement = $this->con->prepare($sql);
        $statement->bindParam(1,$chatID);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $results = $statement->fetchAll();


        $arr = array();
        foreach($results as $row){
            array_push($arr,$row["chatmessage"]);
        }



        $this->dbClose();
        return $arr;
    }


}