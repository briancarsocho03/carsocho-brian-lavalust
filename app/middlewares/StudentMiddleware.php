<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle($next)
    {
        if (isset($_SESSION['student_access']) && $_SESSION['student_access'] === true) {
            return $next();
        }

        $_SESSION['middleware_message'] = 'Profile access denied. Please visit the Student Home first.';

        header('Location: ' . site_url('student'));
        exit;
    }
}