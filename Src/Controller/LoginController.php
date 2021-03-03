<?php

/*
 * A Controller handling login functions
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
 * @since 16.02.21
 *
 */

include_once "DbController.php";
include_once "Model/DbCredentials.php";
include_once "UserController.php";
include_once "SessionController.php";

class LoginController
{

    public function login($inputUsername, $inputPassword)
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);
        $userController = new UserController();
        $sessionController = new SessionController();

        //Checks if inputed username even exists in the DB
        if ($userController->usernameExists($inputUsername)) {

            error_log("User accessed");

            $statement = "SELECT password FROM user WHERE  username = '" . $inputUsername . "'";

            error_log($statement);

            $result = $dbController->executeQuery($statement);

            $value = mysqli_fetch_array($result)["password"];

            error_log($value);

            if (password_verify($inputPassword, $value)) {

                //Creates a unique Session ID
                $sessionController->createSession($inputUsername);

                header('location: http://localhost/wiki/?site=articleView');
            } else {
                error_log("Password wrong");
                header('location: http://localhost/wiki/?site=login%20message=failed');
            }

        } else {
            header('location: http://localhost/wiki/?site=login%20message=failed');
        }
    }

    //Maybe make own function for it

//    public function isPasswordCorrect($username, $password):bool{
//
//        $dbCredentials = new DbCredentials();
//        $dbController = new DbController($dbCredentials);
//        $userController = new UserController();
//
//        //ToDo: Prevent SQL Injections
//
//        $statement = "SELECT password FROM user WHERE username ='".$username."'";
//
//        $userPassword = $dbController->executeQuery($statement);
//
//
//
//        if(password_verify($password,$userPassword)){
//            error_log("User password is the same");
//
//            return true;
//        }else{
//            return false;
//        }
//
//    }
}