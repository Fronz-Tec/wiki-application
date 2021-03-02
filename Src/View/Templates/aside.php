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
    include_once "Controller/VisibilityController.php";

    $categoryController = new CategoryController();

    $userController = new UserController();
    $articleController = new ArticleController();
    $visibilityController = new VisibilityController();

    if ($_GET["site"] == "articleCreation") {

    ?>


    <p class='menuTitle'>Save Article</p>

    <div class='menuWrapper'>
        <select class='filterBox' name='visibilityFilter' id='categoryFilter' form='articleCreationForm'>";
            <?php

            if ($userController->isAdmin() || $userController->isCurator()) {
                $visibilities = $visibilityController->getAlVisibilities();
            }else {
                $visibilities = $visibilityController->getUserVisibility();
            }

            foreach ($visibilities as $visibility) {
                echo "<option value='" . $visibility["id"] . "'>" . $visibility["name"] . "</option>";
            }

            ?>

        </select>

        <button type='submit' form='articleCreationForm' class='menuButtonDown'>Save Article</button>
    </div>

    <hr class='menuDivider'>

    <?php

    if ($_GET["site"] == "articleCreation" && isset($_GET["articleId"])) {

        $currentArticleId = $_GET["articleId"];

    ?>

    <div class='menuWrapper'>
        <form  method='post' action='Controller/EventHandling.php'>
            <p class='menuTitle'>Add Links</p>
            <input type='text' class='menuInputTop' name='linkURL' id='linkURL' placeholder='URL' required>
            <input type='text' class='menuInput' name='linkName' id='linkName' placeholder='Title' required>
            <?php

                echo "<input type='hidden' name='linkHidden' id='linkHidden' value='" . $currentArticleId . "'>";

            ?>
            <button type='submit' class='menuButtonDown'>Save Link</button>
        </form>
    </div>

    <hr class='menuDivider'>";

    <?php

    }
    }

    if ($_GET["site"] == "articleView") {

    ?>

    <p class='menuTitle'>Filter</p>
    <div class='menuWrapper'>
        <form method='post' action='Controller/EventHandling.php'>
            <select class='filterBox' name='categoryFilter' id='categoryFilter'>
                <?php

                $categories = $categoryController->getAllCategories();

                foreach ($categories as $category) {
                    echo "<option value='" . $category["id"] . "'>" . $category["name"] . "</option>";
                }

                ?>
            </select>
            <br>

            <input type='hidden' id='filter' name='filter'>
            <button class='menuButtonDown' type='submit'>Apply</button>
        </form>
    </div>

    <hr class='menuDivider'>

    <p class='menuTitle'>Create</p>
    <div class='menuWrapper'>
        <form method='post' action='Controller/EventHandling.php'>
            <input type='hidden' id='createNew' name='createNew'>
            <button class='menuButtonUp' type='submit'>Create New</button>
        </form>
                    
        <form method='post' action='Controller/EventHandling.php'>
            <input type='hidden' id='editArticle' name='editArticle'>
            <button class='menuButtonDown' type='submit'>Edit</button>
        </form>
    </div>
                
    <hr class='menuDivider'>
                
    <?php

    }

    ?>

    <p class='menuTitle'>User</p>
    <div class='menuWrapper'>
        <?php

        if ($userController->isAdmin()) {

        ?>
        <form method='post' action='Controller/EventHandling.php'>
            <input type='hidden' name='userCreation'>
            <button class='menuButtonUp' type='submit'>Create User</button>
        </form>

        <form method='post' action='Controller/EventHandling.php'>
            <input type='hidden' name='userEdit'>
            <button class='menuButtonDown' type='submit'>Edit Profile</button>
        </form>

        <?php

        } else {

        ?>

        <form method='post' action='Controller/EventHandling.php'>
            <input type='hidden' name='userEdit'>
            <button class='menuButtonUp' type='submit'>Edit Profile</button>
        </form>

        <?php

        }

        ?>
    </div>
        
    <hr class='menuDivider'>

    <div class='menuWrapper'>
        <form method="post" action="Controller/EventHandling.php">
            <input type="hidden" name="articleView" id="articleView">
            <button type="submit" class='menuButtonUp'>To Main Page</button>
        </form>

        <form method="post" action="Controller/EventHandling.php">
            <input type="hidden" name="logout" id="logout">
            <button type="submit" class='menuButtonDown'>Logout</button>
        </form>
    </div>
</div>