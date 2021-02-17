<?php


?>


<div class="articleContainer" id="articleContainer">

    <?php
        include_once "Controller/ArticleController.php";

        $articleController = new ArticleController();
        $articles = $articleController->getAllArticles();

        if($articles !== null) {
            foreach ($articles as $article) {
                $articleId = $article["id"];
                $currentArticleCategory = $articleController->getArticleCategory($articleId);
                $currentArticleAuthor = $articleController->getArticleAuthor($articleId);
                $currentArticleVisibility = $articleController->getArticleVisibility($articleId);

                error_log("Current Category: " . $currentArticleCategory);

                //ToDo: Check If User can see the visibility of the article
                if ($currentArticleVisibility == "full") {

                    echo "
                    <div class='articleBox'>
                    <span><h1 class='article articleTitle'>" . $article["title"] . "</h1></span>
                    <span><h2 class='article articleDate'>" . $article["date"] . "</h2></span>
                    <span><h3 class='article articleCategory'>" . $currentArticleCategory . "</h3></span>
                    <span><h3 class='article articleAuthor'>" . $currentArticleAuthor . "</h3></span>";

                    if (isset($_SESSION["isAdmin"]) == true) {
                        echo "<span><h3 class='article articleVisibility'>" . $currentArticleVisibility . "</h3></span>";
                    }

                    echo "<span><p class='article'>" . $article["text"] . "</p></span>
                }

                </div>";

                }
            }

        }
        ?>

</div>