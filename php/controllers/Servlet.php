<?php

require_once "php/core/Facade.php";

class Servlet{

    private $facade;
    private $errors = array();
    private $users;
    private $chat;
   // private $user;

    public function __construct(){

        $this->facade = new Facade();

        //Define something to show that we are coming from the servlet
        //Pages loaded without this will show an error
        define("SERVLET", 1);
    }

    public function processRequest(){

        session_start();

        $nextPage = "";
        $action = "home";
        if(isset($_POST['action'])){
            $action = $_POST['action'];
        }elseif(isset($_GET['action'])){
            $action = $_GET['action'];
        }

        $redirect = true;

        switch($action){
            case "home":
                $nextPage = $this->home();
                break;
            case "login":
                $nextPage = $this->login();
                break;
            case "register":
                $nextPage = $this->register();
                break;
            case "chat":
                $nextPage = $this->chat();
                break;
            case "createaccount":
                $nextPage = $this->addAccount();
                break;
            case "getfriends":
                $this->getFriends();
                $redirect=false;
                break;
            case "sendmessage":
                $redirect = false;
                $this->sendMessage();
                break;
            case "getmessages":
                $redirect = false;
                $this->getMessages();
                break;
            case "newpass":
                $nextPage = $this->newPass();
                break;
            case "updatepassword":
                $nextPage = $this->updatePassword();
                break;
            case "logout":
                $nextPage = $this->logout();
                break;
            default:
                $nextPage = $this->home();
                break;
        }

        if($redirect)
           require_once($nextPage);
    }

    private function newPass(){

        if(isset($_SESSION["user"])){
            $nextPage = "newpass.php";
        }else{
            $nextPage = "login.php";
            return $nextPage;
        }

        return $nextPage;
    }

    private function updatePassword(){

        if(isset($_SESSION["user"])){
            $nextPage = "chatoverview.php";
        }else{
            $nextPage = "login.php";
            return $nextPage;
        }

        $username = $_SESSION["user"]->getUsername();

        if(isset($_POST["newPassword"])){
            $newPassword = $_POST["newPassword"];

            $change = $this->facade->changePass($username, $newPassword);

            if($change)
                array_push($this->errors, "Password Updated Successfully");
            else
                array_push($this->errors, "Could not update password.");

        }else{
            array_push($this->errors, "You did not enter a password"); // push to $this->notifications for example
            $nextPage = "newpass.php";
        }

        return $nextPage;
    }

    private function home(){
        if(isset($_SESSION["user"])){
            $nextPage = "chatoverview.php";
        }else{
            $nextPage = "login.php";
        }

        return $nextPage;
    }

    private function sendMessage(){
        $chatId = $_POST["chatID"];
        $messageToSend = $_SESSION["user"]->getUsername();
        $messageToSend .= ": " . $_POST["message"];


        $this->facade->saveMessage($chatId,$messageToSend);
    }

    private function login(){

        // login logic
        // call facade..
        // if logged in - go to member area
        // else - return error message
        $nextPage = "login.php";

        if(isset($_POST['username'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
        }elseif(isset($_SESSION["user"])){
            $nextPage = "chatoverview.php";
            return $nextPage;
        }else{
            $nextPage = "login.php";
            return $nextPage;
        }

        $user = $this->facade->login($username,$password);

        if($user==null){
            // If we are logged in
            // call facade to get data
            // Pass data to view.
            array_push($this->errors,"Wrong username/password");
        }else{
            $_SESSION["user"] = $user;

            $nextPage = "chatoverview.php";
        }
        return $nextPage;

    }

    private function logout(){

        $this->facade->logout();

        $nextPage = "login.php";

        return $nextPage;
    }

    private function register(){

        $nextPage = "register.php";
        return $nextPage;
    }

    private function addAccount(){

        //CHECK POST

        $nextPage = "login.php";

        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];

        $addAccount = $this->facade->addAccount($username, $password, $firstname);

        switch($addAccount){
            case "account_exists":
                array_push($this->errors, "An account with this username already exists, please try again.");
                $nextPage = "register.php";
                break;
            case "missing_details":
                array_push($this->errors, "You missed out some details, please try again.");
                $nextPage = "register.php";
                break;
            case "account_created":
                array_push($this->errors, "Account created successfully.");
                break;
        }

        return $nextPage;
    }

    private function chat(){

        $user1 = $_SESSION["user"];
        $user2 = $_GET["user"];

        // Now we need to initiate a chat.

        // Make a new chat if the chat doesn't exist

        $this->chat = $this->facade->retrieveChat($user1, $user2);
        if($this->chat == null){
            //echo "chat was null";
            $this->chat = $this->facade->storeChat($user1,$user2);
        }

        $nextPage = "chat.php";
        return $nextPage;
    }

    private function getMessages(){

        $chatID = $_GET["chatid"];
        $messages = $this->facade->getMessages($chatID);

        $xmlString = "<?xml version=\"1.0\"?>";
        $xmlString .= "\n<messages>";

        foreach($messages as $message){
            $xmlString .= "\n<message>";
            $xmlString .= "\n" . $message;
            $xmlString .= "\n</message>";
        }

        $xmlString .= "\n</messages>";

        echo $xmlString;
    }

    private function getFriends(){

        //header("Content-type: text/xml;charset=utf-8");
        $username = $_SESSION["user"]->getUsername();
        $this->users = $this->facade->getFriends($username);
        $xmlString = "<?xml version=\"1.0\"?>";
        $xmlString .= "\n<friends>";
        foreach($this->users as $friend)
        {
            $xmlString .= "\n<friend>";
            $xmlString .= "\n<username>";
            $xmlString .= "\n" . $friend->getUsername();
            $xmlString .= "\n</username>";
            $xmlString .= "\n</friend>";
        }

        $xmlString .= "\n</friends>";


        preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/","\n",$xmlString);
        echo $xmlString;


    }

}