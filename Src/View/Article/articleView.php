<?php


?>


<div class="articleContainer" id="articleContainer">

    <?php
        include_once "Controller/ArticleController.php";

        $articleController = new ArticleController();
        $articles = $articleController->getAllArticles();

        if($articles !== null){
            foreach ($articles as $article){
                $articleId = $article["id"];
                $currentArticleCategory = $articleController->getArticleCategory($articleId);
                $currentArticleAuthor= $articleController->getArticleAuthor($articleId);
                $currentArticleVisibility = $articleController->getArticleVisibility($articleId);

                error_log("Current Category: ".$currentArticleCategory);

                echo "
                <div class='articleBox'>
                    <span><h1 class='article title'>".$article["title"]."</h1></span>
                    <span><h2 class='article date'>".$article["date"]."</h2></span>
                    <span><h3 class='article category'>".$currentArticleCategory."</h3></span>
                    <span><h3 class='article category'>".$currentArticleAuthor."</h3></span>
                    <span><h3 class='article category'>".$currentArticleVisibility."</h3></span>
                    <span><p class='article text'>".$article["text"]."</p></span>
                </div>";

            }
        }


        ?>

</div>
