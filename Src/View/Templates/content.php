<?php

/*
 * The content file of the project
 *
 * used for the display of the website content and dynamically load parts of the website
 *
 * LICENSE:
 *
 * @category
 * @package Src
 * @subpackage Templates
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 0.1
 * @link
 * @since 16.02.21
 *
 */

?>

<aside>
    <?php

    include_once "aside.php";

    ?>
</aside>

<main>
    <p>B</p>


    <form action="Controller/EventHandling.php" method="post">
        <input type="hidden" name="articleTest" id="article" value="true">
        <button onclick="this.form.submit()">TestArticle</button>
    </form>

    <?php


//    if(isset($_SESSION["sessionID"])){
//        error_log("sessionId");
//    }else{
//        if($_GET["site" == "articleView"]){
//            include_once("./View/Article/articleView.php");
//        }else{
//            include_once("./View/Pages/login.php");
//        }
//    }

    include_once("./View/Article/articleView.php");

    ?>

    <p>Test</p>

</main>