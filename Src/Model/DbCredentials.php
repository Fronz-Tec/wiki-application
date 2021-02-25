<?php
/*
 * used in the DbController for the DB Credentials to build up the connection
 *
 * LICENSE:
 *
 * @category
 * @package Src
 * @subpackage Model
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 0.1
 * @link
 * @since 16.02.21
 *
 */

//namespace DbCredentials;


class DbCredentials
{

    private const DB_SERVER='localhost';
    private const DB_USERNAME='wikiUser';
    private const DB_PASSWORD='67JeQUlqI6PRLTTd';
    private const DB_NAME='miniwiki';



    //getter used in the DbController to get required information to connect with DB
    public function getCredentials(): array
    {
        return array(
            "DB_SERVER" => $this::DB_SERVER,
            "DB_USERNAME" => $this::DB_USERNAME,
            "DB_PASSWORD" => $this::DB_PASSWORD,
            "DB_NAME" => $this::DB_NAME,
        );
    }


}