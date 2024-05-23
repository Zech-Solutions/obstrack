<?php

class UserController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = $this->model("User");
    }

    public function index()
    {
        $users = $this->user->all();
        $this->view('user/index', [
            'users' => $users
        ]);
    }

    public function register()
    {
        $form = [
            'username' => $this->input('username'),
            'password' => $this->input('password'),
            'first_name' => $this->input('first_name'),
            'middle_name' => $this->input('middle_name'),
            'last_name' => $this->input('last_name'),
            'dob' => $this->input('dob'),
            'gender' => $this->input('gender'),
        ];

        // Additional validation and processing here
        $userModel = $this->model('User');
        if ($userModel->register($form)) {
            $this->redirect('home');
        } else {
            $this->view('register', ['error' => 'Registration failed']);
        }
    }

    public function login()
    {
        $form = [
            'username' => $this->input('username'),
            'password' => $this->input('password')
        ];

        // Additional validation and processing here
        $userModel = $this->model('User');
        if ($userModel->login($form)) {
            $this->redirect('home');
        } else {
            // $this->view('register', ['error' => 'Registration failed']);
            $this->redirect('home');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('home');
    }
}
