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

?>


<div class="articleContainer">
    <div class='articleBox'>
        <form id="articleCreationForm" method="post" action="Controller/EventHandling.php">
            <div class='container-fluid'>
                <div class='row'>

                    <?php

                    $currentUser = $_SESSION["username"];

                    if(isset($_GET["articleId"]) && $articleController->hasPermissionToEdit($_GET["articleId"])){

                        $articleId = $_GET["articleId"];

                        $loadedArticle = $articleController->getArticleById($articleId);

                        if($userController->isAdmin() || $userController->isCurator()){
                            echo" <span class='col-sm-1'>
                            <select id='articleVisibility' name='articleVisibility'>";

                            $visibilities = $visibilityController->getAlVisibilities();

                            foreach ($visibilities as $visibility){
                                echo "<option value='".$visibility["id"]."'>".$visibility["name"]."</option>";
                            }

                            echo"</select>
                                </span>

                                <span class='col-sm-1'>";
                        }else{
                            echo "<span class='col-sm-2'>";
                        }

                    ?>

                    <select id="articleCategory" name="articleCategory">
                        <?php

                        foreach ($categories as $category){
                            echo "<option value='".$category["id"]."'>".$category["name"]."</option>";
                        }

                        ?>

                    </select>
                    </span>

                    <?php

                        echo"
                        <br>
                            </span>
                        <span class='col-sm-8'>
                            <input type=text id='articleTitle' name='articleTitle' class='articleTitleEdit' placeholder='Title' value='".$loadedArticle[0][2]."' required>
                        </span>
                        
                        <span class='col-sm-2'></span>
                        <br>
        
                        <input type='hidden' id='articleHiddenUpdate' name='articleHiddenUpdate'>
                        <input type='hidden' id='articleId' name='articleId' value='".$loadedArticle[0][0]."'>
        
                        <span class='col-sm-2'></span>
                        <span class='col-sm-8'>
                            <textarea id='articleText' name='articleText' class='articleText'required>".$loadedArticle[0][3]."</textarea>
                        </span>
                        <span class='col-sm-2'></span>";



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





            </div>
        </form>
    </div>

</div>
