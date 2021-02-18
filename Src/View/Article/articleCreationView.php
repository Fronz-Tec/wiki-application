<?php



?>


<div class="article articleCreationContainer">

    <form id="articleCreationForm" method="post" action="Controller/EventHandling.php">
        <select id="articleCategory" name="articleCategory">
            <?php

            include_once "Controller/CategoryController.php";

            $categoryController = new CategoryController();
            $categories = $categoryController->getAllCategories();


            foreach ($categories as $category){
                echo "<option value='".$category["id"]."'>".$category["name"]."</option>";
            }

            ?>
        </select>
        <br>

        <input type="text" id="articleTitle" name="articleTitle" class="articleTitle" placeholder="Title" required>
        <br>

        <input type="hidden" id="articleHidden" name="articleHidden" value="articleHidden" required>

        <textarea id="articleText" name="articleText" class="articleText" required></textarea>






    </form>

</div>
