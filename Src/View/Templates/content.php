<?php

/*
 * The content file of the project
 *
 * used for the display of the website content and dynamically load parts of the website
 *
 * LICENSE:
 *
 * @category
 * @package Src
 * @subpackage Templates
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 0.1
 * @link
 * @since 16.02.21
 *
 */

?>

<aside>
    <?php

    if(isset($_SESSION["sessionID"]) != null){

        include_once "aside.php";

    }

    ?>
</aside>

<main>
    <?php


    if(isset($_SESSION["sessionID"]) != null){

        if($_GET["site"] == "articleView"){
            include_once("View/Article/articleView.php");
        }else if($_GET["site"] == "articleCreation"){
            include_once("View/Article/articleCreationView.php");
        }else if($_GET["site"] == "userCreation"){
            include_once ("View/User/userCreation.php");
        }else{
            header('location: http://localhost/wiki/?site=articleView');
        }

    }else{

        if($_GET["site"] == "login"){
            include_once("./View/Pages/login.php");
        }else{
            header('location: http://localhost/wiki/?site=login');
        }
//
//
//        header('location: http://localhost/wiki/?site=login');
    }

//    include_once("./View/Article/articleView.php");
//    include_once("./View/Article/articleCreationView.php");
//
//    include_once("./View/Pages/login.php");
//
//
//    include_once("./View/User/userCreation.php");

    ?>

    <p>Test</p>

</main>