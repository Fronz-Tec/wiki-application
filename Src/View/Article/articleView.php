<?php

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

        if($userController->getRoleOfUser() != "4"){

            if(isset($_GET["permission"])) {
                echo "Eigene werden geladen";

                if ($_GET["permission"] == "own") {

                    $articles = $articleController->getAllByOwn();

                }
            }
            if(isset($_GET["permission"])){
                if($_GET["permission"] == "own"){
                    $articles == $articleController->getAllByOwn();
                }

            }else if(isset($_GET["category"])){

                $category = $_GET["category"];

                if($currentUserGroup == 2) {
                    $currentUserId = $userController->getUserId();

                    $articles = $articleController->getAllPermissionedArticle("author_fsid",
                        $currentUserId, "visibility_fsid", 6,$category);
                }else{
                    $articles = $articleController->getAllPermissionedArticle("visibility_fsid",
                        4,"visibility_fsid",6,$category);
                }


            }else{
                if($userController->isAdmin() || $userController->isCurator()){
                    $articles = $articleController->getAllArticles();
                }else{

                    if($currentUserGroup == 2) {
                        $currentUserId = $userController->getUserId();

                        $articles = $articleController->getAllPermissionedArticle("author_fsid",
                            $currentUserId, "visibility_fsid", 6,null);
                    }else{
                        $articles = $articleController->getAllPermissionedArticle("visibility_fsid",
                            4,"visibility_fsid",6,null);
                    }
                }
            }


            if ($articles !== null) {

                foreach ($articles as $article) {
                    $articleId = $article["id"];
                    $currentArticleCategory = $articleController->getArticleCategory($articleId);
                    $currentArticleAuthor = $articleController->getArticleAuthor($articleId);
                    $currentArticleVisibility = $articleController->getArticleVisibility($articleId);

    //                if($articleController->hasPermissionToEdit($article["id"])){

                    echo "
                            <div class='articleBox'>
                                <div class='container-fluid'>
                                    <p>" . $article["visibility_fsid"] . "</p>
                                    <div class='row'>
                                        
                                        <span class='col-sm-2'>
                                            <p class='articleCategory'>" . $currentArticleCategory . "</p>
                                        </span>
                                        
                                        <span class='col-sm-8'>
                                            <h1 class='display-3 articleTitle'>" . $article["title"] . "</h1>
                                        </span>
                                        
                                        <span class='col-sm-1'>
                                            <p class='articleDate'>" . $article["date"] . "</p>
                                        </span>
                                        
                                        <span class='col-sm-1'>
                                            <p class='article articleAuthor'>" . $currentArticleAuthor . "</p>
                                       </span>
                                    </div>
                                    
                                    <div class='row'>
    
                                        <span class='col-sm-1'></span>
                                        
                                        <span class='col-sm-10'>
                                            <p class='article'>" . $article["text"] . "</p>
                                        </span>
                                        
                                        <span class='col-sm-1'></span>
                                    
                                    </div>";

                    if ($userController->isAdmin() || $userController->isCurator() ||
                        $articleController->hasPermissionToEdit($article["id"])) {
                        echo "<span>
                                    <h3 class='article articleVisibility'>" . $currentArticleVisibility . "</h3>
                                    <form id='articleCreationForm' method='post' action='Controller/EventHandling.php'>
                                        <input type='hidden' name='articleId' id='articleId' value='" . $article["id"] . "'>
                                        <button class='editButton' type='submit'>Edit</button>
                                    </form>
                                </span>";
                    }

                    echo "<div class='row'>
                            <span class='col-sm-2'></span>
                            <span class='col-sm-10'>";

                    $links = $linkController->getAllLinksFromArticle($article["id"]);

                    foreach ($links as $link) {
                        echo "<a href='" . $link["url"] . "' target='_blank'>" . $link["title"] . "</a>";
                    }

                    echo " </span>
                            <span class='col-sm-2'></span>
                          </div>
                       </div>
                     </div>";
//
//                }else{
//                    echo "none found";
//                }
                }
            }
        }else{
            echo "Sorry you are disabled";
        }

        ?>

</div>