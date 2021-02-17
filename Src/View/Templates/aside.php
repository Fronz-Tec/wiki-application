<?php
/*
 * The aside file of the project
 *
 * used for the side navigation of the website
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


<div class="sideMenu">

    <?php

        if(isset($_SESSION["sessionID"])){

            ?>

            <form action="../../Controller/EventHandling.php" method="post">
                <input type="hidden" name="logout" id="logout" value="true">
                <button onclick="this.form.submit()">Logout</button>
            </form>

    <?php

        }

    ?>

</div>