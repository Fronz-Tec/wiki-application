<?php
/*
 * A Controller handling link functions
 *
 *
 * LICENSE:
 *
 * @category View
 * @package Src
 * @subpackage View
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 1.0
 * @link
 * @since 17.02.21
 *
 */
?>

<div class="articleContainer" id="articleContainer">

    <?php
    include_once "Controller/ArticleController.php";
    include_once "Controller/UserController.php";
    include_once "Controller/LinkController.php";

    $articleController = new ArticleController();
    $userController = new UserController();
    $linkController = new LinkController();

    $articles = null;

    $currentUserGroup = $userController->getUserVisibility();


    //ToDo: Check If User can see the visibility of the article

    if ($userController->getRoleOfUser() != "4") {

        if (isset($_GET["permission"])) {

            if ($_GET["permission"] == "own") {

                $articles = $articleController->getAllByOwn();
            }
        }

        if (isset($_GET["permission"])) {

            if ($_GET["permission"] == "own") {

                $articles == $articleController->getAllByOwn();
            }

        } else if (isset($_GET["category"])) {

            $category = $_GET["category"];

            if ($currentUserGroup == 2) {

                $currentUserId = $userController->getUserId();

                $articles = $articleController->getAllPermissionedArticle("author_fsid",
                            $currentUserId, "visibility_fsid", 6, $category);
            } else {
                $articles = $articleController->getAllPermissionedArticle("visibility_fsid",
                            4, "visibility_fsid", 6, $category);
            }
        } else {

            if ($userController->isAdmin() || $userController->isCurator()) {

                $articles = $articleController->getAllArticles();
            } else {

                if ($currentUserGroup == 2) {

                    $currentUserId = $userController->getUserId();

                    $articles = $articleController->getAllPermissionedArticle("author_fsid",
                                $currentUserId, "visibility_fsid", 6, null);
                } else {
                    $articles = $articleController->getAllPermissionedArticle("visibility_fsid",
                        4, "visibility_fsid", 6, null);
                }
            }
        }

        if ($articles !== null) {

            foreach ($articles as $article) {
                $articleId = $article["id"];
                $currentArticleCategory = $articleController->getArticleCategory($articleId);
                $currentArticleAuthor = $articleController->getArticleAuthor($articleId);
                $currentArticleVisibility = $articleController->getArticleVisibility($articleId);

                ?>

    <div class='articleBox'>
        <div class='container-fluid'>
             <?php

             echo "<p>" . $article["visibility_fsid"] . "</p>";

             ?>
            <div class='row'>
                <div class='col-sm-2'>
                    <?php

                    echo "<p class='articleCategory'>" . $currentArticleCategory . "</p>";

                    ?>
                </div>
                                        
                <div class='col-sm-8'>
                    <?php

                    echo "<h1 class='display-3 articleTitle'>" . $article["title"] . "</h1>";

                    ?>
                </div>
                                        
                <div class='col-sm-1'>
                    <?php

                    echo " <p class='articleDate'>" . $article["date"] . "</p>";

                    ?>
                </div>

                <div class='col-sm-1'>
                    <?php

                    echo "<p class='article articleAuthor'>" . $currentArticleAuthor . "</p>";

                    ?>
                </div>
            </div>
                                    
            <div class='row'>
                <div class='col-sm-1'>

                </div>
                                        
                <div class='col-sm-10'>
                    <?php

                    echo "<p class='article'>" . $article["text"] . "</p>";

                    ?>
                </div>

                <div class='col-sm-1'>

                </div>
            </div>

            <?php

            if ($userController->isAdmin() || $userController->isCurator() ||
                $articleController->hasPermissionToEdit($article["id"])) {

                echo "
                <div>
                    <h3 class='article articleVisibility'>" . $currentArticleVisibility . "</h3>
                    <form id='articleCreationForm' method='post' action='Controller/EventHandling.php'>
                        <input type='hidden' name='articleId' id='articleId' value='" . $article["id"] . "'>
                         <button class='editButton' type='submit'>Edit</button>
                    </form>
                </div>";

            }

            ?>
            <div class='row'>
                <div class='col-sm-2'>

                </div>

                <div class='col-sm-10'>
                    <?php

                    $links = $linkController->getAllLinksFromArticle($article["id"]);

                    foreach ($links as $link) {
                        echo "<a href='" . $link["url"] . "' target='_blank'>" . $link["title"] . "</a>";
                    }

                    ?>

                </div>

                <div class='col-sm-2'>

                </div>
            </div>
        </div>
    </div>

    <?php

            }
        }
    } else {
        echo "Sorry you are disabled";
    }

    ?>
</div>