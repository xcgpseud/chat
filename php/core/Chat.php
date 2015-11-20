<?php

/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 29/08/2015
 * Time: 14:18
 */




class Chat{


    // Class Variables
    private $id, $user1, $user2;
    private $messages = array();


    public function __construct($id, $user1,$user2){
        $this->id = $id;
        $this->user1 = $user1;
        $this->user2 = $user2;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @return mixed
     */
    public function getUser1()
    {
        return $this->user1;
    }

    /**
     * @param mixed $user1
     */
    public function setUser1($user1)
    {
        $this->user1 = $user1;
    }

    /**
     * @return mixed
     */
    public function getUser2()
    {
        return $this->user2;
    }

    /**
     * @param mixed $user2
     */
    public function setUser2($user2)
    {
        $this->user2 = $user2;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param array $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }






}








?>