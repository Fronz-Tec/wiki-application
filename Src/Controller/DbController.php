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
 * @version 0.1
 * @link
 * @since 16.02.21
 *
 */


use DbCredentials\DbCredentials;



class DbController
{

    public $dbCredentials;
    public $isConnected;
    public $connection;

    /**
     * DbController constructor.
     * @param $dbCredentials
     * @param $isConnected
     * @param $connection
     */
    public function __construct($dbCredentials, $isConnected, $connection)
    {
        $this->dbCredentials = $dbCredentials;
        $this->isConnected = $isConnected;
        $this->connection = $connection;
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

        error_log( $tempCredential["DB_SERVER"],
            $tempCredential["DB_USERNAME"],
            $tempCredential["DB_PASSWORD"],
            $tempCredential["DB_NAME"]);


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
        if ($this->connection == null) {
            dbConnect();
        }

        return $this->connection;
    }



    public function isConnected():bool
    {

        if($this->connection != null) {
            $this->isConnected = true;
        }else{
            $this->isConnected = false;
        }

        error_log($this->isConnected);
        return  $this->isConnected;
    }



    public function createDbTables(){


        if($this->isConnected() == true) {


            //Checks if Category is empty
            $statementCategory = "SELECT * FROM `category` WHERE id > 0";
            $resultCategory = mysqli_query($this->getDbConnection(), $statementCategory);

            if ($resultCategory->num_rows < 1) {

                $statement = "INSERT INTO `category` (`id`, `name`) VALUES (NULL, 'news'), (NULL, 'general')";
                $result = mysqli_query($this->getDbConnection(), $statement);

                error_log($result);
            }


            //Checks if Groups is empty
            $statementGroups = "SELECT * FROM `groups` WHERE id > 0";
            $resultGroups = mysqli_query($this->getDbConnection(), $statementGroups);

            if ($resultGroups->num_rows < 1) {

                $statement = "INSERT INTO `groups` (`id`, `name`) VALUES (NULL, 'internal'), (NULL, 'external')";
                $result = mysqli_query($this->getDbConnection(), $statement);

                error_log($result);

            }

            //Checks if Visibility is empty
            $statementGroups = "SELECT * FROM `visibility` WHERE id > 0";
            $resultGroups = mysqli_query($this->getDbConnection(), $statementGroups);

            if ($resultGroups->num_rows < 1) {

                $statement = "INSERT INTO `groups` (`id`, `name`) VALUES (NULL, 'internal'), (NULL, 'external')";
                $result = mysqli_query($this->getDbConnection(), $statement);

                error_log($result);

            }

            //Checks if Roles is empty
            $statementRoles = "SELECT * FROM `roles` WHERE id > 0";
            $resultRoles = mysqli_query($this->getDbConnection(), $statementRoles);

            if ($resultRoles->num_rows < 1) {

                $statement = "INSERT INTO `roles` (`id`, `name`) VALUES (NULL, 'admin'), (NULL, 'redaktor'), (NULL, 'user');";
                $result = mysqli_query($this->getDbConnection(), $statement);

                error_log($result);

            }



    }



}