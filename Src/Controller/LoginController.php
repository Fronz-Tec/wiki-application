<?php



use DbController;

class LoginController
{

    public $dbController;

    public function getDbController():DbController
    {
        return $this->dbController;
    }



    public function verifyUser($username, $password){

    }

}