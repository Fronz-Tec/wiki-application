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
    include_once "Controller/ArticleController.php";
    include_once "Controller/CategoryController.php";

    $categoryController = new CategoryController();

    $userController = new UserController();
    $articleController = new ArticleController();


    echo "<p>test</p>";

        if($_GET["site"] == "articleCreation"){

            echo "<button type='submit' form='articleCreationForm'>Save Article</button>";

            if($_GET["site"] == "articleCreation" && isset($_GET["articleId"])){

                $currentArticleId = $_GET["articleId"];

                echo "
                    <form  method='post' action='Controller/EventHandling.php'>
                        <p class='menuTitle'>Add Links</p>
                        <input type='text' name='linkURL' id='linkURL' placeholder='URL' required>
                        <input type='text' name='linkName' id='linkName' placeholder='Title' required>
                        <input type='hidden' name='linkHidden' id='linkHidden' value='".$currentArticleId."'>
                        <button type='submit'>Save Link</button>
                       </form>
                    
                ";


            }

        }

        if($_GET["site"] == "articleView"){
            echo "
                <p class='menuTitle'>Filter</p>
                <form method='post' action='Controller/EventHandling.php'>
                <select class='filterBox' name='categoryFilter' id='categoryFilter'>";

            $categories = $categoryController->getAllCategories();

            foreach ($categories as $category){
                echo "<option value='".$category["id"]."'>".$category["name"]."</option>";
            }

            echo"</select><br>
                    <input type='hidden' id='filter' name='filter'>
                    <button class='menuButtonDown' type='submit'>Apply</button>
                </form>

                <hr class='menuDevider'>

                <p class='menuTitle'>Create</p>
                <form method='post' action='Controller/EventHandling.php'>
                    <input type='hidden' id='createNew' name='createNew'>
                    <button class='menuButtonUp' type='submit'>Create New</button>
                </form>
                
                <form method='post' action='Controller/EventHandling.php'>
                    <input type='hidden' id='editArticle' name='editArticle'>
                    <button class='menuButtonDown' type='submit'>Edit</button>
                </form>
                
                <hr class='menuDevider'>
                
            ";
        }


        if ($userController->isAdmin()){

            echo "<p class='menuTitle'>User</p>
                <form method='post' action='Controller/EventHandling.php'>
                    <input type='hidden' name='userCreation'>
                    <button class='menuButtonUp' type='submit'>Create User</button>
                </form>
                ";
        }
        echo "<form method='post' action='Controller/EventHandling.php'>
                   <input type='hidden' name='userEdit'>
                   <button class='menuButtonDown' type='submit'>Edit Profile</button>
               </form>
               <hr class='menuDevider'>";


    ?>

    <form method="post" action="Controller/EventHandling.php">
        <input type="hidden" name="logout" id="logout">
        <button type="submit" class='menuButtonDown'>Logout</button>
    </form>

</div>