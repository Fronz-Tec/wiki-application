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
 * @version 0.4
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


    public function getDbCredentials()
    {
        return $this->dbCredentials;
    }



    //Connection Function
    function dbConnect()
    {

        global $connection;

        $tempCredentialObj = $this->getDbCredentials();
        $tempCredential = $tempCredentialObj->getCredentials();

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

            $this->executeQuery($sql);

            //Checks if Roles is empty
            $statementRoles = "SELECT * FROM `roles` WHERE id > 0";
            $resultRoles = $this->executeQuery($statementRoles);

            if ($resultRoles->num_rows < 1) {

                $statement = "INSERT INTO `roles` (`id`, `name`) VALUES (NULL, 'admin'), 
                                          (NULL, 'redaktor'), (NULL, 'user'),(NULL,'disabled');";
                $this->executeQuery($statement);


            }


            //create category
            $sql = "CREATE TABLE IF NOT EXISTS category(
                id INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) UNIQUE NOT NULL,
                PRIMARY KEY (id)
            )";

            $resultRoles = $this->executeQuery($sql);

            //Checks if Category is empty
            $statementCategory = "SELECT * FROM `category` WHERE id > 0";
            $resultCategory = $this->executeQuery($statementCategory);

            if ($resultCategory->num_rows < 1) {

                $statement = "INSERT INTO `category` (`id`, `name`) VALUES (NULL, 'news'), (NULL, 'general')";
                $this->executeQuery($statement);

            }



            //create visibility
            $sql = "CREATE TABLE IF NOT EXISTS visibility(
                id INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) UNIQUE NOT NULL,
                PRIMARY KEY (id)
            )";

            $this->executeQuery($sql);

            //Checks if Visibility is empty
            $statementGroups = "SELECT * FROM `visibility` WHERE id > 0";
            $resultVisibility = $this->executeQuery($statementGroups);

            if ($resultVisibility->num_rows < 1) {

                $statement = "INSERT INTO `visibility` (`id`, `name`) VALUES (NULL, 'draft'), (NULL, 'open'), 
                                               (NULL, 'internal'), (NULL, 'full'), (NULL, 'edited'), (NULL, 'external')";
                $this->executeQuery($statement);
            }

            //create groups
            $sql = "CREATE TABLE IF NOT EXISTS `groups`(
                id INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) UNIQUE NOT NULL,
                PRIMARY KEY (id)
            )";

            $this->executeQuery($sql);

            //Checks if Groups is empty
            $statementGroups = "SELECT * FROM `groups` WHERE id > 0";
            $resultGroups = $resultRoles = $this->executeQuery($statementGroups);

            if ($resultGroups->num_rows < 1) {

                $statement = "INSERT INTO `groups` (`id`, `name`) VALUES (NULL, 'internal'), (NULL, 'external')";
                $this->executeQuery($statement);

            }


            //create articles
            $sql = "CREATE TABLE `article` (
                `id` int(11) UNSIGNED AUTO_INCREMENT NOT NULL,
              `date` timestamp NOT NULL DEFAULT current_timestamp(),
              `title` varchar(255) NOT NULL,
              `text` text NOT NULL,
              `author_fsid` int(11) NOT NULL,
              `visibility_fsid` int(11) NOT NULL,
              `category_fsid` int(11) NOT NULL,
               PRIMARY KEY (`id`)
              )";

            $this->executeQuery($sql);

            $sql = "ALTER TABLE `article`
              ADD KEY `author_fsid` (`author_fsid`),
              ADD KEY `visibility_fsid` (`visibility_fsid`),
              ADD KEY `category_fsid` (`category_fsid`)";

            $this->executeQuery($sql);

            $sql = "ALTER TABLE `article`
              ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`author_fsid`) REFERENCES `user` (`id`),
              ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`visibility_fsid`) REFERENCES `visibility` (`id`),
              ADD CONSTRAINT `article_ibfk_3` FOREIGN KEY (`category_fsid`) REFERENCES `category` (`id`);";

            $this->executeQuery($sql);


            //create links
            $sql = "CREATE TABLE IF NOT EXISTS `links` (
                  `article_fsid` int(11) NOT NULL,
                  `title` varchar(255) NOT NULL,
                   `url` archar(255) NOT NULL
                )";

            $this->executeQuery($sql);

            $sql = "ALTER TABLE `links`
            ADD KEY `article_fsid` (`article_fsid`)";

            $this->executeQuery($sql);

            $sql = "ALTER TABLE `links`
            ADD CONSTRAINT `links_ibfk_1` FOREIGN KEY (`article_fsid`) REFERENCES `article` (`id`)";

            $this->executeQuery($sql);


            //create user
            $sql = "CREATE TABLE IF NOT EXISTS `user` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `username` varchar(255) NOT NULL,
                  `mail` varchar(255) NOT NULL,
                  `password` varchar(255) NOT NULL,
                  `group_fsid` int(11) NOT NULL,
                  `role_fsid` int(11) NOT NULL,
                  `joindate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                  `current_session` varchar(255) NOT NULL,
    			  PRIMARY KEY(`id`)
                )";

            $this->executeQuery($sql);

            $sql = "ALTER TABLE `user`
            ADD KEY `group_fsid` (`group_fsid`),
            ADD KEY `role_fsid` (`role_fsid`)";

            $this->executeQuery($sql);

            $sql = "ALTER TABLE `user`
            ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`group_fsid`) REFERENCES `groups` (`id`),
             ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`role_fsid`) REFERENCES `roles` (`id`)";

            $this->executeQuery($sql);


            $statementUser = "SELECT * FROM `user` WHERE id > 0";
            $resultUser = $resultRoles = $this->executeQuery($statementUser);

            if ($resultUser->num_rows < 1) {

                $adminPassword = "%%21b81D";
                $hashedAdminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

                $statement = "INSERT INTO `user` (`id`, `username`,`mail`,`password`,`group_fsid`,`role_fsid`) 
                VALUES (NULL, 'admin','admin@admin.com','".$hashedAdminPassword."',1,1)";
                $this->executeQuery($statement);
            }
        }

    }


    public function executeQuery($statement)
    {

        return mysqli_query($this->getDbConnection(), $statement);

    }


    public function getAll($table):array
    {

        $statement = "SELECT * FROM ".$table." ";

        $result = array();

        $tempResult = $this->executeQuery($statement);

        while ($entry = mysqli_fetch_array($tempResult)) {

            array_push($result, $entry);

        }

        return $result;
    }

    public function getAllBy($table, $condition, $conditionCheck):array
    {
        $statement = "SELECT * FROM ".$table." WHERE ".$condition."='".$conditionCheck."'";

        $result = array();

        $tempResult = $this->executeQuery($statement);

        while ($entry = mysqli_fetch_array($tempResult)) {

            array_push($result, $entry);

        }

        return $result;
    }

    public function getAllByAnd($table,$condition1,$conditionCheck1,$condition2,$conditionCheck2):array
    {
        $statement = "SELECT * FROM `".$table."` WHERE ".$condition1."='".$conditionCheck1."' 
        AND ".$condition2."='".$conditionCheck2."'";

        $result = array();

        $tempResult = $this->executeQuery($statement);

        while ($entry = mysqli_fetch_array($tempResult)) {

            array_push($result, $entry);

        }

        return $result;

    }

    public function getAllByOr($table,$condition1,$conditionCheck1,$condition2,$conditionCheck2):array
    {
        $statement = "SELECT * FROM `".$table."` WHERE `".$condition1."`=".$conditionCheck1." 
        OR `".$condition2."`=".$conditionCheck2;

        $result = array();

        $tempResult = $this->executeQuery($statement);

        while ($entry = mysqli_fetch_array($tempResult)) {

            array_push($result, $entry);

        }

        return $result;

    }



    public function doesExist($table, $tableRow, $toCheck):bool
    {

        //ToDO: Change to prevent SQL Injections

        $statement = "SELECT * FROM ".$table." WHERE ".$tableRow." = '".$toCheck."'";

        error_log($statement);

        $tempResult = $this->executeQuery($statement);

        if ($tempResult->num_rows > 0){
            $doesExist = true;
        }else{
            $doesExist = false;
        }

        return $doesExist;

    }



    //ToDO: Function to call for every user Input, to make sure, SQL Injections aren't possible
    public function invalidateSQLInjection($sqlQuery, $userInput){

    }






}