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
 * @version 1.0
 * @link
 * @since 16.02.21
 *
 */


include_once "Controller/UserController.php";
$userController = new UserController();


if(isset($_GET["site"])){
    if($_GET["site"] != "login"){



?>
<aside>
    <?php

    if(isset($_SESSION["sessionID"]) != null){

        if($userController->getRoleOfUser() != "4") {

            include_once "aside.php";

        }

    }
}

    ?>
</aside>

<?php
}
?>

<main>
    <?php


    if(isset($_SESSION["sessionID"]) != null && isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true){

        if($_GET["site"] == "articleView"){
            include_once("View/Article/articleView.php");
        }else if($_GET["site"] == "articleCreation"){
            include_once("View/Article/articleCreationView.php");
        }else if($_GET["site"] == "userCreation"){
            include_once ("View/User/userCreation.php");
        }else if($_GET["site"] == "userProfile"){
            include_once ("View/User/userProfile.php");
        }else{
            header('location: http://localhost/wiki/?site=articleView');
        }

    }else {

        if ($_GET["site"] == "login") {
            include_once("./View/Pages/login.php");
        } else {
            header('location: http://localhost/wiki/?site=login');
        }
    }

    ?>


</main>