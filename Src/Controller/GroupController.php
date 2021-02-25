<?php

/*
 * A Controller handling group functions
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
 * @since 18.02.21
 *
 */

include_once "DbController.php";
include_once "Model/DbCredentials.php";

class GroupController
{

    public function getAllGroups():array
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAll("groups");

    }
}