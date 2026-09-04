<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->model('UsersModel');
    }

    public function index()
    {
        $users = $this->UsersModel->all();

        $data['users'] = $users;

        $this->call->view('users/index', $data);
    }
}