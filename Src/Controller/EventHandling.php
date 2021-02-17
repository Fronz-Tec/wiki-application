<?php

/*
 * A file handling user interaction and calling neccessary functzions
 *
 *
 * LICENSE:
 *
 * @category File
 * @package Src
 * @subpackage Controller
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 0.2
 * @link
 * @since 17.02.21
 *
 */

include_once "ArticleController.php";



if (isset($_POST["logout"])){
    LogoutController::logout();
}


if (isset($_POST["articleTest"])){
//    $articleController = new ArticleController();
//    $articleController->getAllArticles();
    header("location: ../View/Article/articleView.php");
}