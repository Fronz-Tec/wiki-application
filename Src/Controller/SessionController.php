<?php

/*
 * A Controller handling link functions
 *
 *
 * LICENSE:
 *
 * @category File
 * @package Src
 * @subpackage Controller
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 1.0
 * @link
 * @since 19.02.21
 *
 */

include_once "DbController.php";
include_once "Model/DbCredentials.php";
include_once "UserController.php";

class SessionController
{

    public function createSession($inputUsername){

        session_start();

        $sessionID = uniqid();

        $_SESSION["sessionID"] = $sessionID;
        $_SESSION["loggedIn"] = true;
        $_SESSION["username"] = $inputUsername;

        return $this->saveSessionId($sessionID);

    }

    public function saveSessionId($sessionId)
    {

        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        $username = $_SESSION["username"];

        $hashedSessionId = password_hash($sessionId, PASSWORD_DEFAULT);

        $statement = "UPDATE `user` SET current_session='".$hashedSessionId."' WHERE username='".$username."'";

        return $dbController->executeQuery($statement);

    }

    public function deleteSessionId()
    {
        session_start();

        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        $username = $_SESSION["username"];

        $statement = "UPDATE `user` SET `current_session`=null WHERE username='".$username."'";
        return $dbController->executeQuery($statement);

    }


    public function verifySession():bool
    {

        $isVerified = false;

        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        if(!isset($_SESSION)){
            session_start();
        }

        $username = $_SESSION["username"];

        $statement = "Select current_session FROM user WHERE username ='".$username."'";

        $tempResult = $dbController->executeQuery($statement);

        $value = mysqli_fetch_assoc($tempResult)["current_session"];

        if(!isset($value)){
            $_SESSION["loggedIn"] = false;

            return false;
        }

        $sessionId = $_SESSION["sessionID"];

        if(password_verify($sessionId,$value)){
                //SessionId and saved sessionID is same
            $isVerified = true;
        }

        return $isVerified;

    }

}