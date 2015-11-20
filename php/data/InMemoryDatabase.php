<?php


require_once "php/interfaces/IDatabase.php";
require_once "php/core/Account.php";
final class InMemoryDatabase implements IDatabase{
    
    static $data = array();


    static $inMemoryDb;
    private function __construct(){
        echo "called constructor";
    }


    public static function getDatabase(){
        if(InMemoryDatabase::$inMemoryDb == null){
            InMemoryDatabase::$inMemoryDb = new InMemoryDatabase();
        }
        return InMemoryDatabase::$inMemoryDb;
    }



    public function addAccount($username,$password, $firstname){
        
        // Loop through the current accounts to see if the username already exists
        // If the username does not exist, we will push the new account in to the array & return true
        // Else, return false
        
        $accountExists = false;
        
        foreach($this::$data as $account){
            if($account->getUsername() == $username){
                $accountExists = true;
                break;
            }
        }
        
        if($accountExists){
            return false;
        }else{
            $account = new Account();
            $account->setUsername($username);
            $account->setPassword($password);
            $account->setFirstname($firstname);

            echo "adding to data..";
            array_push(InMemoryDatabase::$data, $account);
            var_dump($this::$data);
            return true;
        }
        
    }
    public function updatePassword($username, $newPass){}
    
    
    
    public function login($username, $password)
    {
        // Take the username and password given
        // Check the database, in this case the array, in a loop, for the user and password
        // if user found, return true. else false.

//        var_dump($this->data);
        foreach(InMemoryDatabase::$data as $account) {
            if ($account->getUsername() == $username && $account->getPassword() == $password) {
                return $account;
            } else {
                return null;
            }
        }
    }


    public function getFriends($currentUser){
        // for each of the users
        // if we are on the current user, skip it
        // otherwise, add it to an array of users
        // return the array
        $users = array();

        foreach($this->data as $account){
            if($currentUser != $account->getUsername()){
                array_push($users, $account);
            }
        }

        return $users;
    }

    public function logout(){}
    
}

?>