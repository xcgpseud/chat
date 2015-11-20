<?php

/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 01/09/2015
 * Time: 14:23
 */

require_once "php/data/Database.php";
require_once "php/data/Operations.php";

class MySqlDatabase extends Database implements IDatabase
{
    public function __construct(){
        parent::__construct();

    }

    public function addAccount($username, $password, $firstname){

        //If anything was left empty
        if(empty($username) || empty($password) || empty($firstname)){
            return "missing_details";
        }

        $this->dbConnect();

        $sql = "SELECT * FROM accounts WHERE username =?";
        $statement = $this->con->prepare($sql);
        $statement->bindParam(1,$username);

        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $results = $statement->fetchAll();

        //Disconnect
        $this->dbClose();

        if(!empty($results)){
            return "account_exists";
        }

        //Reconnect
        $this->dbConnect();

        $sql = "INSERT INTO accounts(username, password, firstname) VALUES(?, ?, ?)";
        $statement = $this->con->prepare($sql);
        $statement->bindParam(1, $username);
        $statement->bindParam(2, $password);
        $statement->bindParam(3, $firstname);

        $statement->execute();

        //Disconnect
        $this->dbClose();

        return "account_created";
    }

    public function updatePassword($username, $newPassword){

        $this->dbConnect();

        $sql = "UPDATE accounts SET password =? WHERE username =?";
        $statement = $this->con->prepare($sql);

        $statement->bindParam(1, $newPassword);
        $statement->bindParam(2, $username);

        if($statement->execute()){
            $this->dbClose();
            return true;
        }

        $this->dbClose();
        return false;
    }

    public function login($username, $password)
    {
        $this->dbConnect();

        $sql = "SELECT * FROM accounts WHERE username =? AND password =?";
        $statement = $this->con->prepare($sql);
        $statement->bindParam(1,$username);
        $statement->bindParam(2,$password);

        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $results = $statement->fetchAll();

        // If results is empty
        // Return null
        // Else create an object with the information and return that
        // Close the connection

        foreach($results as $row)
        {
            $account = new Account();
            $account->setUsername($row["username"]);
            $account->setPassword($row["password"]);
            $account->setFirstname($row["firstname"]);
            $this->con = null;
            return $account;
        }

        //Disconnect
        $this->dbClose();

        return null;
    }

    public function logout(){

        //For now just destroy the session
        session_destroy();
    }

    public function getFriends($currentUser){

        $this->dbConnect();

        $sql = "SELECT * FROM accounts WHERE username <> ?";
        $statement = $this->con->prepare($sql);
        $statement->bindParam(1,$currentUser);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $results = $statement->fetchAll();

        $users = array();

        foreach($results as $row){

            $account = new Account();

            $account->setUsername($row["username"]);
            $account->setPassword($row["password"]);
            $account->setFirstname($row["firstname"]);

            array_push($users, $account);
        }

        $this->dbClose();

        return $users;

    }

}


?>