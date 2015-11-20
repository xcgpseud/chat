<?php

/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 29/08/2015
 * Time: 14:25
 */

require_once "php/interfaces/IChatDatabase.php";
require_once "php/core/Chat.php";

class ChatDb implements IChatDatabase
{

    // class variables
    private $chats = array();


    public function storeChat($user1,$user2)
    {
        // We can just put it in the $chats array. And for the moment not care about duplicate chats.
        array_push($this->chats, $chat);
        return $chat;
    }

    public function retrieveChat($user1,$user2)
    {
        // for each over the chats
        // if the chat matches both user1 and user2
        // then return the chat
        // and break
        foreach($this->chats as $chat){
            if(($chat->getUser1() == $user1 && $chat->getUser2() == $user2) ||
                ($chat->getUser2() == $user1 && $chat->getUser1() == $user2)){
                return $chat;
            }
        }

        return null;
    }

    // We know what we need namely: the interface methods


}

?>