<?php

include_once "SessionController.php";

class LogoutController
{

    public function logout(){
        error_log("Logout called");

        $sessionController = new SessionController();
        $sessionController->deleteSessionId();

        session_destroy();

        header('location: http://localhost/wiki/?site=login');
    }
}