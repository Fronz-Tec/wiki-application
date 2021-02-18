<?php

include_once "DbController.php";
include_once "Model/DbCredentials.php";

class GroupController
{

    public function getAllGroups():array
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAll("groups");

    }
}