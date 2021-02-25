<?php

/*
 * A Controller handling category functions
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
 * @since 17.02.21
 *
 */

include_once "DbController.php";
include_once "Model/DbCredentials.php";

class CategoryController
{
    public function getAllCategories(): array
    {
        $statement = "SELECT * FROM category";

        $dbCredentials = new DbCredentials();

        $dbController = new DbController($dbCredentials);

        $result = array();

        $tempResult = $dbController->executeQuery($statement);

        while ($category = mysqli_fetch_array($tempResult)) {

            array_push($result, $category);

        }

        return $result;

    }
}