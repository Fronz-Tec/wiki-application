<?php

/*
 * A Controller handling logout functions
 *
 *
 * LICENSE:
 *
 * @category File
 * @package Src
 * @subpackage Controller
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 1.0
 * @link
 * @since 17.02.21
 *
 */

include_once "SessionController.php";

class LogoutController
{

    public function logout()
    {
        $sessionController = new SessionController();
        $sessionController->deleteSessionId();

        session_destroy();

        header('location: http://localhost/wiki/?site=login');
    }
}