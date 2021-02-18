<?php

include_once "DbController.php";
include_once "Model/DbCredentials.php";

class RoleController
{

    public function getAllRoles(): array
    {

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAll("roles");

    }

}