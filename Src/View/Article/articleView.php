<?php

?>


<div class="articleContainer" id="articleContainer">

    <?php
        include_once "Controller/ArticleController.php";

        $articleController = new ArticleController();

        $articles = null;


        //ToDo: Check If User can see the visibility of the article

        if(isset($_GET["permission"])) {
            echo "Eigene werden geladen";

            if ($_GET["permission"] == "own") {

                $articles = $articleController->getAllByOwn();


            } else if ($_GET["permission"] == "curator" || $_GET["permission"] == "admin") {

                //Check if user really is admin or curator

                echo "Alle Artikel";
            } else {

            }
        }else {

            $articles = $articleController->getAllArticles();

        }

        if ($articles !== null) {
            foreach ($articles as $article) {
                $articleId = $article["id"];
                $currentArticleCategory = $articleController->getArticleCategory($articleId);
                $currentArticleAuthor = $articleController->getArticleAuthor($articleId);
                $currentArticleVisibility = $articleController->getArticleVisibility($articleId);

                error_log("Current Category: " . $currentArticleCategory);


//                if ($currentArticleVisibility == "full") {

                echo "
                    <div class='articleBox'>
                        <div class='container-fluid'>
                            <div class='row'>
                                <span class='col-sm-2'><p class='articleCategory'>" . $currentArticleCategory . "</p></span>
                                <span class='col'><h1 class='display-3 articleTitle'>" . $article["title"] . "</h1></span>
                                <span class='col-sm-2'><p class='articleDate'>" . $article["date"] . "</p></span>
                                
                                <span class='col-sm-1'><p class='article articleAuthor'>" . $currentArticleAuthor . "</p></span>
                            </div>
                        </div>";

                if (isset($_SESSION["role"]) == "admin" || isset($_SESSION["role"]) == "curator") {
                    echo "<span>
                            <h3 class='article articleVisibility'>" . $currentArticleVisibility . "</h3>
                            <form id='articleCreationForm' method='post' action='Controller/EventHandling.php'>
                                <input type='hidden' name='' value='".$article["id"]."'>
                                <button type='submit'>Edit</button>
                            </form>
                        </span>";
                }

                echo "<span><p class='article'>" . $article["text"] . "</p></span>

                </div>";
//                }
            }
        }else{
            //ToDo Message No Articles found
        }

        ?>

</div>