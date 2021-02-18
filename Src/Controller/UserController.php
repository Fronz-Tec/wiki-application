<?php


include_once "DbController.php";
include_once "Model/DbCredentials.php";

class UserController
{

    public function createNewUser($username,$email,$password,$role,$group){


        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if($this->usernameExists($username) == true){

            //ToDo: Output Message
            error_log("Username already exists");
        }else{

            if($this->verifyMail($email) == true){

                if ($this->emailExists($email) == true){
                    //ToDo: Output Message
                    error_log("Email already exists");
                }else{

                    error_log("Saving Of User");

                    //ToDo: Prevent SQL Injection
                    $statement = "INSERT INTO `user` (`username`, `mail`, `password`, `group_fsid`,`role_fsid`) VALUES ( '".$username."', '".$email."', '".$hashedPassword."', '".$group."' '".$role."');";

                    $dbCredentials = new \DbCredentials\DbCredentials();
                    $dbController = new DbController($dbCredentials);

                    return $dbController->executeQuery($statement);
                }
            }else{
                //Todo Output Message
                error_log("Invalid Mail");

                return null;
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

        return $this->doesExist("user","mail",$email);

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

    public function hashPassword($password){

        //ToDo: Prevent SQL Injections before hashing just to be sure

        $passwordToHash = $password;
        $hashedPassword = password_hash($passwordToHash, PASSWORD_DEFAULT);

        //Check if password was really hashed
        if($hashedPassword != $password){
            return $hashedPassword;
        }

        return null;

    }


    public function isAdmin(){

    }

    public function isCurator(){

    }



}