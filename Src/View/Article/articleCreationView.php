<?php



?>


<div class="article articleCreationContainer">

    <form id="articleCreationForm" method="post" action="Controller/EventHandling.php">
        <select id="articleCategory" name="articleCategory">
            <?php

            include_once "Controller/CategoryController.php";
            include_once "Controller/ArticleController.php";
            include_once "Controller/UserController.php";
            include_once "Controller/VisibilityController.php";

            $categoryController = new CategoryController();

            $categories = $categoryController->getAllCategories();

            $articleController = new ArticleController();
            $userController = new UserController();
            $visibilityController = new VisibilityController();

            foreach ($categories as $category){
                echo "<option value='".$category["id"]."'>".$category["name"]."</option>";
            }

            ?>

            </select>

        <?php

            $currentUser = $_SESSION["username"];

            if(isset($_GET["articleId"]) && $articleController->hasPermissionToEdit($_GET["articleId"])){

                $articleId = $_GET["articleId"];

                $loadedArticle = $articleController->getArticleById($articleId);

                if($userController->isAdmin() || $userController->isCurator()){
                    echo"<select id='articleVisibility' name='articleVisibility'>";

                    $visibilities = $visibilityController->getAlVisibilities();

                    foreach ($visibilities as $visibility){
                        echo "<option value='".$visibility["id"]."'>".$visibility["name"]."</option>";
                    }

                    echo"</select>";
                }

                echo"
                <br>

                <input type=text id='articleTitle' name='articleTitle' class='articleTitle' placeholder='Title' value='".$loadedArticle[0][2]."' required>
                <br>

                <input type='hidden' id='articleHiddenUpdate' name='articleHiddenUpdate'>
                <input type='hidden' id='articleId' name='articleId' value='".$loadedArticle[0][0]."'>

                <textarea id='articleText' name='articleText' class='articleText'required>".$loadedArticle[0][3]."</textarea>";


            }else{

            ?>

        <br>

        <input type="text" id="articleTitle" name="articleTitle" class="articleTitle" placeholder="Title" required>
        <br>

        <input type="hidden" id="articleHidden" name="articleHidden" value="articleHidden" required>

        <textarea id="articleText" name="articleText" class="articleText" required></textarea>

        <?php
        }
        ?>




    </form>

</div>
