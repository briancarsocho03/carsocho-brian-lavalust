<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function login()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            redirect('products');
        }

        $data = [];

        if (isset($_SESSION['auth_message'])) {
            $data['error'] = $_SESSION['auth_message'];
            unset($_SESSION['auth_message']);
        }

        $this->call->view('auth/login', $data);
    }

    public function authenticate()
    {
        $username = $this->io->post('username');
        $password = $this->io->post('password');

        $this->call->database();
        $lava = lava_instance();
        $user = $lava->db->raw(
            'SELECT id, username, password, is_active FROM users WHERE username = ? LIMIT 1',
            [$username]
        )->fetch(PDO::FETCH_ASSOC);

        if ($user && strtolower((string) $user['username']) === 'admin' && (int) $user['is_active'] === 1 && password_verify($password, $user['password'])) {

            session_regenerate_id(true);
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            redirect('products');

        } else {

            $data['error'] = 'Invalid username or password.';

            $this->call->view('auth/login', $data);
        }
    }

    public function logout()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $cookie = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httponly']
            );
        }

        session_destroy();

        redirect('login');
    }
}