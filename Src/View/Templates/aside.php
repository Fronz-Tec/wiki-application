<?php
/*
 * The aside file of the project
 *
 * used for the side navigation of the website
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


<div class="sideMenu">


    <?php

    include_once "Controller/UserController.php";

    $userController = new UserController();


    echo "<p>test</p>";

        if($_GET["site"] == "articleCreation" || $_GET["site"] == "articleCreation" && isset($_GET["articleId"])){

            echo "<button type='submit' form='articleCreationForm'>Save Article</button>";

        }

        if($_GET["site"] == "articleView"){
            echo "
                <p class='menuText'>Create</p>
                <form method='post' action='Controller/EventHandling.php'>
                    <input type='hidden' id='createNew' name='createNew'>
                    <button type='submit'>Create New</button>
                </form>
                
                <form method='post' action='Controller/EventHandling.php'>
                    <input type='hidden' id='editArticle' name='editArticle'>
                    <button type='submit'>Edit</button>
                </form>
                
                <hr class='menuDevider'>
                
            ";
        }


        if ($userController->isAdmin()){

            echo "<form method='post' action='Controller/EventHandling.php'>
                    <input type='hidden' name='userCreation'>
                    <button type='submit'>Create User</button>
                </form>";
        }

    ?>

    <form method="post" action="Controller/EventHandling.php">
        <input type="hidden" name="logout" id="logout">
        <button type="submit">Logout</button>
    </form>

    <p>agsdzhadha</p>

</div>