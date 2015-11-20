<?php


interface IDatabase{
    
    
    public function addAccount($username, $password, $firstname);
    public function updatePassword($username, $newPass);
    public function login($username, $password);
    public function logout();
    public function getFriends($currentUser);
    
    
}