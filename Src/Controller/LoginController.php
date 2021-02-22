<?php

include_once "DbController.php";
include_once "Model/DbCredentials.php";
include_once "UserController.php";
include_once "SessionController.php";

class LoginController
{


    public function login($inputUsername, $inputPassword){

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);
        $userController = new UserController();
        $sessionController = new SessionController();

        //Checks if inputed username even exists in the DB
        if($userController->usernameExists($inputUsername)){

            $statement = "SELECT password FROM user WHERE  username = '" . $inputUsername . "'";

            $result = $dbController->executeQuery($statement);

            $value = mysqli_fetch_array($result)["password"];

            if (password_verify($inputUsername, $value)) {

                //Creates a unique Session ID
                $sessionController->createSession($inputUsername);

                header('location: http://localhost/wiki/?site=articleView');
            }else{
                error_log("Password wrong");
            }

        }else{
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