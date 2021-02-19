<?php

include_once "DbController.php";
include_once "Model/DbCredentials.php";

class VisibilityController
{

    public function getAlVisibilities(): array
    {

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAll("visibility");

    }


}