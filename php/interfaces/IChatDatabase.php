<?php

/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 29/08/2015
 * Time: 14:32
 */
interface IChatDatabase
{

    // What does the chat database need to do?

    // Store chats
    // Retrieve chats

    public function storeChat($user1, $user2);
    public function retrieveChat($user1, $user2);


}

?>