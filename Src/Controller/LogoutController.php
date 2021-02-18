<?php

class LogoutController
{

    public function logout(){
        error_log("Logout called");

        session_start();
        session_destroy();

        header('location: http://localhost/wiki/?site=login');
    }
}