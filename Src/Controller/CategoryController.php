<?php

include_once "DbController.php";
include_once "Model/DbCredentials.php";

class CategoryController
{
    public function getAllCategories(): array
    {
        $statement = "SELECT * FROM category";

        $dbCredentials = new \DbCredentials\DbCredentials();

        $dbController = new DbController($dbCredentials);

        $result = array();

        $tempResult = $dbController->executeQuery($statement);

        while ($category = mysqli_fetch_array($tempResult)) {

            array_push($result, $category);

        }

        return $result;

    }
}