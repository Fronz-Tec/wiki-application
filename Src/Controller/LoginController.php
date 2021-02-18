<?php

include_once "DbController.php";
include_once "Model/DbCredentials.php";
include_once "UserController.php";

class LoginController
{




    public function login($inputUsername, $inputPassword){

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);
        $userController = new UserController();

        //Checks if inputed username even exists in the DB
        if($userController->usernameExists($inputUsername)){

            error_log("Username exists in DB");

            $statement = "SELECT password FROM user WHERE  username = '" . $inputUsername . "'";
            error_log("SELECT * FROM user WHERE username = '" . $inputUsername . "' 
                AND password = '" . password_hash($inputPassword, PASSWORD_DEFAULT) . "'");

            $result = $dbController->executeQuery($statement);

            $value = mysqli_fetch_array($result)["password"];

            if (password_verify($inputUsername, $value)) {

                error_log("Password correct");

                session_start();

                //Creates a unique Session ID
                $sessionID = uniqid();

                $_SESSION["SessionID"] = $sessionID;
                $_SESSION["username"] = $inputUsername;

                error_log($_SESSION["SessionID"]);

                header('location: http://localhost/wiki/?site=articleView');
            }else{
                error_log("Password wrong");
            }

        }else{
            error_log("Password incorrect");

            header('location: http://localhost/wiki/?site=login%20message=failed');
        }


    }



    //Maybe make own function for it

//    public function isPasswordCorrect($username, $password):bool{
//
//        $dbCredentials = new \DbCredentials\DbCredentials();
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