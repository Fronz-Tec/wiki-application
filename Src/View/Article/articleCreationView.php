<?php



?>


<div class="article articleCreationContainer">

    <form id="articleCreationForm">
        <select>
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

        <input type="text" id="articleTitle" class="articleTitle" placeholder="Title" required>
        <br>

        <input type="hidden" id="articleHidden" required>

        <textarea id="articleTextBox" class="articleText" required></textarea>






    </form>

</div>
