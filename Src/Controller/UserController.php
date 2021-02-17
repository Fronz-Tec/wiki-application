<?php


include_once "DbController.php";
include_once "Model/DbCredentials.php";

class UserController
{


    public function createNewUser($username,$email,$password,$role){


        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if($this->usernameExists($username) == true){

            //ToDo: Output Message
            error_log("Username already exists");
        }else{

            if($this->verifyMail($email) == true){

                if ($this->emailExists($email) == true){
                    //ToDo: Output Message
                    error_log("Username already exists");
                }else{

                    $statement = "INSERT INTO `user` (`username`, `mail`, `password`, `role_fsid`) VALUES ( '".$username."', '".$email."', '".$hashedPassword."', '".$role."', ";

                    $dbCredentials = new \DbCredentials\DbCredentials();
                    $dbController = new DbController($dbCredentials);
                    $tempResult = $dbController->executeQuery($statement);
                }
            }else{
                //Todo Output Message
                error_log("Invalid Mail");
            }

        }

    }


    public function verifyMail($email):bool{
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }


    public function usernameExists($username):bool{

        return $this->doesExist("user","username",$username);

    }

    public function emailExists($email):bool{

        return $this->doesExist("user","email",$email);

    }

    public function doesExist($table, $tableRow, $toCheck):bool{

        //ToDO: Change to prevent SQL Injections
        $statement = "SELECT * FROM ".$table." WHERE ".$tableRow." = '".$toCheck."'";

        $dbCredentials = new \DbCredentials\DbCredentials();

        $dbController = new DbController($dbCredentials);

        $tempResult = $dbController->executeQuery($statement);

        if ($tempResult->num_rows > 0){
            $doesExist = true;
        }else{
            $doesExist = false;
        }

        return $doesExist;

    }



}