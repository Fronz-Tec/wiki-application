<?php

/*
 * A Controller handling role functions
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

class RoleController
{

    public function getAllRoles(): array
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAll("roles");
    }


    public function getRoleName($roleId): string
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        $statement = "SELECT `name` FROM `roles` WHERE `id`=" . $roleId;

        return mysqli_fetch_assoc($dbController->executeQuery($statement))["name"];
    }

}