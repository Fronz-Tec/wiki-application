<?php
/*
 * The controller for DB connection
 *
 *
 * LICENSE:
 *
 * @category class
 * @package Src
 * @subpackage Controller
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 0.2
 * @link
 * @since 16.02.21
 *
 */


use DbCredentials\DbCredentials;

 $connection = null;

class DbController
{

    public $dbCredentials;
    public $isConnected;


    /**
     * DbController constructor.
     * @param $dbCredentials
     * @param $isConnected
     * @param $connection
     */
    public function __construct($dbCredentials)
    {
        global $connection;

        $this->dbCredentials = $dbCredentials;

        if ($connection == null){
            $this->getDbConnection();
        }

        $this->createDbTables();
    }


    public function getDbCredentials():DbCredentials
    {
        return $this->dbCredentials;
    }



    //Connection Function
    function dbConnect()
    {

        global $connection;

        $tempCredentialObj = $this->getDbCredentials();
        $tempCredential = $tempCredentialObj->getCredentials();

        error_log( $tempCredential["DB_SERVER"]);
        error_log($tempCredential["DB_USERNAME"]);
        error_log($tempCredential["DB_PASSWORD"]);
        error_log($tempCredential["DB_NAME"]);


        $connection = new mysqli(
            $tempCredential["DB_SERVER"],
            $tempCredential["DB_USERNAME"],
            $tempCredential["DB_PASSWORD"],
            $tempCredential["DB_NAME"]
        );


        if ($connection->connect_error) {
            die($connection->connect_error);
        }

    }

    function getDbConnection()
    {
        global $connection;

        if ($connection == null) {
            $this->dbConnect();
        }

        return $connection;
    }



    public function isConnected():bool
    {
        global $connection;

        if($connection != null) {
            $this->isConnected = true;
        }else{
            $this->isConnected = false;
        }

        error_log($this->isConnected);
        return  $this->isConnected;
    }



    public function createDbTables()
    {

        global $connection;


        if($this->isConnected() == true) {

            //create roles
            $sql = "CREATE TABLE IF NOT EXISTS roles(
                id INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) UNIQUE NOT NULL,
                PRIMARY KEY (id)
            )";

            mysqli_query($connection, $sql);

            //Checks if Roles is empty
            $statementRoles = "SELECT * FROM `roles` WHERE id > 0";
            $resultRoles = mysqli_query($this->getDbConnection(), $statementRoles);

            if ($resultRoles->num_rows < 1) {

                $statement = "INSERT INTO `roles` (`id`, `name`) VALUES (NULL, 'admin'), (NULL, 'redaktor'), (NULL, 'user');";
                $result = mysqli_query($this->getDbConnection(), $statement);

                error_log($result);

            }


            //create category
            $sql = "CREATE TABLE IF NOT EXISTS category(
                id INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) UNIQUE NOT NULL,
                PRIMARY KEY (id)
            )";

            mysqli_query($connection, $sql);

            //Checks if Category is empty
            $statementCategory = "SELECT * FROM `category` WHERE id > 0";
            $resultCategory = mysqli_query($this->getDbConnection(), $statementCategory);

            if ($resultCategory->num_rows < 1) {

                $statement = "INSERT INTO `category` (`id`, `name`) VALUES (NULL, 'news'), (NULL, 'general')";
                $result = mysqli_query($this->getDbConnection(), $statement);

                error_log($result);
            }



            //create visibility
            $sql = "CREATE TABLE IF NOT EXISTS visibility(
                id INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) UNIQUE NOT NULL,
                PRIMARY KEY (id)
            )";

            mysqli_query($connection, $sql);

            //Checks if Visibility is empty
            $statementGroups = "SELECT * FROM `visibility` WHERE id > 0";
            $resultGroups = mysqli_query($this->getDbConnection(), $statementGroups);

            if ($resultGroups->num_rows < 1) {

                $statement = "INSERT INTO `groups` (`id`, `name`) VALUES (NULL, 'internal'), (NULL, 'external'), (NULL, 'full')";
                $result = mysqli_query($this->getDbConnection(), $statement);

                error_log($result);

            }

            //create groups
            $sql = "CREATE TABLE IF NOT EXISTS 'groups'(
                id INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) UNIQUE NOT NULL,
                PRIMARY KEY (id)
            )";

            mysqli_query($connection, $sql);

            //Checks if Groups is empty
            $statementGroups = "SELECT * FROM `groups` WHERE id > 0";
            $resultGroups = mysqli_query($this->getDbConnection(), $statementGroups);

            if ($resultGroups->num_rows < 1) {

                $statement = "INSERT INTO `groups` (`id`, `name`) VALUES (NULL, 'internal'), (NULL, 'external')";
                $result = mysqli_query($this->getDbConnection(), $statement);

                error_log($result);

            }


            //create articles
            $sql = "CREATE TABLE IF NOT EXISTS `article` (
                  `id` int(11) NOT NULL,
                  `date` timestamp NOT NULL DEFAULT current_timestamp(),
                  `title` varchar(255) NOT NULL,
                  `text` text NOT NULL,
                  `author_fsid` int(11) NOT NULL,
                  `visibility_fsid` int(11) NOT NULL,
                  `category_fsid` int(11) NOT NULL,
                  PRIMARY KEY (id),
                  FOREIGN KEY (author_fsid) REFERENCES 'user' (id), 
                  FOREIGN KEY (visibility_fsid) REFERENCES 'visibility' (id), 
                  FOREIGN KEY (category_fsid) REFERENCES 'category' (id), 
                )";

            mysqli_query($connection, $sql);


            //create links
            $sql = "CREATE TABLE IF NOT EXISTS `links` (
                  `article_fsid` int(11) NOT NULL,
                  `title` varchar(255) NOT NULL,
                  PRIMARY KEY (art),
                  FOREIGN KEY (art) REFERENCES 'user' (id),
                  FOREIGN KEY (visibility_fsid) REFERENCES 'visibility' (id),
                  FOREIGN KEY (category_fsid) REFERENCES 'category' (id),
                )";

            mysqli_query($connection, $sql);


            //create user
            $sql = "CREATE TABLE IF NOT EXISTS `user` (
                  `id` int(11) NOT NULL,
                  `username` varchar(255) NOT NULL,
                  `mail` varchar(255) NOT NULL,
                  `password` varchar(255) NOT NULL,
                  `group_fsid` int(11) NOT NULL,
                  `role_fsid` int(11) NOT NULL,
                  `joindate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                   PRIMARY KEY (`id`),
                   FOREIGN KEY (`group_fsid`) REFERENCES `groups` (`id`),
                   FOREIGN KEY (`role_fsid`) REFERENCES `roles` (`id`)
                )";

            mysqli_query($connection, $sql);


            $statementUser = "SELECT * FROM `user` WHERE id > 0";
            $resultUser = mysqli_query($this->getDbConnection(), $statementUser);

            if ($resultUser->num_rows < 1) {

                $adminPassword = "%%21b81D";
                $hashedAdminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

                $statement = "INSERT INTO `user` (`id`, `name`,`password`,`roles`) VALUES (NULL, 'admin',".$hashedAdminPassword.")";
                $result = mysqli_query($this->getDbConnection(), $statement);

                error_log($result);

            }
        }

    }


    public function executeQuery($statement){

        return mysqli_query($this->getDbConnection(), $statement);

    }


    //ToDO: Function to call for every user Input, to make sure, SQL Injections aren't possible
    public function invalidateSQLInjection($sqlQuery, $userInput){

    }

    /*EVtl in andere Controller auslagern*/




    public function login($username, $password){

        $tempSessionID = uniqid();




    }


}