<?php

class UserController extends Controller
{
    private $user;
    private $brgy;
    public function __construct()
    {
        $this->user = $this->model("User");
        $this->brgy = $this->model("Barangay");
    }

    public function index()
    {
        $users = $this->user->all();
        $this->view('user/index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $brgys = $this->brgy->all();
        $this->view('user/create', [
            'brgys' => $brgys
        ]);
    }

    public function store()
    {
        if ($this->user->usernameExists($this->input('username'))) {
            $this->session_put('error', 'Username already exists');
            $this->redirect('users/create');
        }

        $form = [
            'username' => $this->input('username'),
            'password' => $this->input('password'),
            'first_name' => $this->input('first_name'),
            'middle_name' => $this->input('middle_name'),
            'last_name' => $this->input('last_name'),
            'dob' => $this->input('dob'),
            'gender' => $this->input('gender'),
            'role' => $this->input('role'),
        ];

        if ($this->input('role') == 'ADMIN')
            $form['brgy_id'] = $this->input('brgy_id');

        if ($this->user->register($form)) {
            $this->redirect('users');
        } else {
            $this->redirect('users');
        }
    }

    public function register()
    {
        if ($this->user->usernameExists($this->input('username'))) {
            $this->session_put('error', 'Username already exists');
            $this->redirectLogin();
        }
        $form = [
            'username' => $this->input('username'),
            'password' => $this->input('password'),
            'first_name' => $this->input('first_name'),
            'middle_name' => $this->input('middle_name'),
            'last_name' => $this->input('last_name'),
            'dob' => $this->input('dob'),
            'gender' => $this->input('gender'),
        ];

        if ($this->user->register($form)) {
            $this->session_put('success', 'Successfully Registered!');
        } else {
            $this->session_put('error', 'Error occur!');
        }
        $this->redirectLogin();
    }

    public function login()
    {
        $form = [
            'username' => $this->input('username'),
            'password' => $this->input('password')
        ];
        if ($this->user->login($form)) {
            $this->redirect('home');
        } else {
            // $this->view('register', ['error' => 'Registration failed']);
            $this->session_put('error', 'Account not match!');
            $this->redirectLogin();
        }
    }

    public function logout()
    {
        unset($_SESSION[SYSTEM]);
        session_destroy();
        // $this->redirect('home');
    }
}
