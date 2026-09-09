<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    public function handle(Closure $next)
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            return $next();
        }

        $_SESSION['auth_message'] = 'Please login first to access Product Management.';

        header('Location: ' . site_url('login'));
        exit;
    }
}