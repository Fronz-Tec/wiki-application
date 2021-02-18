<?php
/*
 * The login page of the project
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

<div class="loginContainer">

    <form id="loginForm" method="post" action="Controller/EventHandling.php">

        <input type="text" id="usernameInput" name="usernameInput" placeholder="username:" class="inputTop"><br>
        <input type="password" id="passwordInput" name="passwordInput" placeholder="password:"><br>
        <input type="hidden" id="loginHidden" value="loginHidden" name="loginHidden">
        <button type="submit" id="submitLogin">Submit</button>

    </form>

</div>


