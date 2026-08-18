<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    public function index()
    {
        $_SESSION['student_access'] = true;

        $student = [
            'name' => 'Brian James Carsocho',
            'course' => 'BS Information Technology',
            'student_id' => '00080',
            'year' => '3rd Year',
            'section' => 'F2',
            'email' => 'briancarsocho03@gmail.com',
            'contact' => '09384236923'
        ];

        $this->call->view('student/index', ['student' => $student]);
    }

    public function profile()
    {
        $student = [
            'name' => 'Brian James Carsocho',
            'course' => 'BS Information Technology',
            'student_id' => '00080',
            'year' => '3rd Year',
            'section' => 'F2',
            'email' => 'briancarsocho03o@gmail.com',
            'contact' => '09384236923'
        ];

        $this->call->view('student/profile', ['student' => $student]);
    }
}