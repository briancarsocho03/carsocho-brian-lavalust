<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function login()
    {
        $this->call->view('auth/login');
    }

    public function authenticate()
    {
        $username = $this->io->post('username');
        $password = $this->io->post('password');

        // Simple credentials for the laboratory exercise
        if ($username === 'admin' && $password === 'admin123') {

            $_SESSION['logged_in'] = true;

            redirect('products');

        } else {

            $data['error'] = 'Invalid username or password.';

            $this->call->view('auth/login', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['logged_in']);

        redirect('login');
    }
}