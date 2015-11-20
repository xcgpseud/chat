<?php

/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 29/08/2015
 * Time: 15:01
 */
class ChatFactory
{
    public static function createChat($user1, $user2){
        return new Chat(-1,$user1, $user2);
    }
}