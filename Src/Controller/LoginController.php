<?php



use DbController;

class LoginController
{

    public $username;


    public function setUsername($username){
       $username = $_POST[""];
    }


    public $dbController;

    public function getDbController():DbController
    {
        return $this->dbController;
    }



    public function verifyUser($username, $password){

    }

}