<?php

include_once "Controller/CategoryController.php";
include_once "Controller/ArticleController.php";
include_once "Controller/UserController.php";
include_once "Controller/VisibilityController.php";
include_once "Controller/LinkController.php";

$categoryController = new CategoryController();

$categories = $categoryController->getAllCategories();

$articleController = new ArticleController();
$userController = new UserController();
$visibilityController = new VisibilityController();
$linkController = new LinkController();

?>

<div class="articleContainer">
    <div class='articleBox'>
        <form id="articleCreationForm" method="post" action="Controller/EventHandling.php" class="was-validated">
            <div class='container-fluid'>
                <div class='row'>
                    <?php

                    $currentUser = $_SESSION["username"];
                    if(isset($_GET["articleId"]) && $articleController->hasPermissionToEdit($_GET["articleId"])){

                        $articleId = $_GET["articleId"];

                        $loadedArticle = $articleController->getArticleById($articleId);

                    ?>
                    <div class='col-sm-2'>
                        <div class="input-group mb-3">
                            <select id="articleCategory" name="articleCategory" class="custom-select" required>
                                 <option value="" hidden>Category</option>
                                 <?php

                                 foreach ($categories as $category){
                                     echo "<option value='".$category["id"]."'>".$category["name"]."</option>";
                                 }

                                ?>
                            </select>

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>
                    </div>

                    <div class='col-sm-8'>
                        <?php

                            echo "
                            <input type=text id='articleTitle' name='articleTitle' class='articleTitleEdit' 
                            placeholder='Title' value='".$loadedArticle[0][2]."' required>";

                        ?>
                        <div class='valid-feedback'>Valid.</div>
                        <div class='invalid-feedback'>Please fill out this field.</div>
                    </div>
                        
                    <div class='col-sm-2'>
                        
                    </div>
                </div>
                    
                <div class='row'>
                    <?php

                    echo "
                        <input type='hidden' id='articleHiddenUpdate' name='articleHiddenUpdate'>
                        <input type='hidden' id='articleId' name='articleId' value='".$loadedArticle[0][0]."'>";

                    ?>
                    <span class='col-sm-1'>
                        
                    </span>
                        
                    <span class='col-sm-10'>
                        <?php

                        echo "
                            <textarea id='articleText' name='articleText' class='articleText'required>
                            ".$loadedArticle[0][3]."</textarea>";

                        ?>
                       <div class='valid-feedback'>Valid.</div>
                       <div class='invalid-feedback'>Please fill out this field.</div>
                    </span>
                        
                    <span class='col-sm-1'>
                        
                    </span>
                </div>
                    
                <div class='row'>
                    <span class='col-sm-2'>
                            
                    </span>
                            
                    <span class='col-sm-10'>";
                        <?php

                        $links = $linkController->getAllLinksFromArticle($_GET["articleId"]);

                        foreach ($links as $link) {
                            echo "<a href='" . $link["url"] . "' target='_blank'>" . $link["title"] . "</a>";
                        }

                        ?>
                    </span>
 
                    <span class='col-sm-2'>
                            
                    </span>
                </div>
                <?php

                }else{

                    ?>
                <br>
                <div class="col-sm-2">
                    <div class="input-group mb-3">
                        <select id="articleCategory" name="articleCategory" class="custom-select" required>
                            <option value="" hidden>Category</option>
                                <?php

                                 foreach ($categories as $category){
                                     echo "<option value='".$category["id"]."'>".$category["name"]."</option>";
                                 }
                                 ?>
                            </select>

                            <div class="valid-feedback">Valid.</div>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <input type="text" id="articleTitle" name="articleTitle" class='articleTitleEdit'
                               placeholder="Title" required>

                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <div class="col-sm-2">

                    </div>
                </div>

                <input type="hidden" id="articleHidden" name="articleHidden" value="articleHidden" required>

                <div class="row">

                    <div class="col-sm-1"></div>

                    <div class="col-sm-10">
                        <textarea id="articleText" name="articleText" class="articleText" required></textarea>

                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <div class="col-sm-1">

                    </div>
                <?php
                }
                ?>

            </div>
        </form>
    </div>
</div>
