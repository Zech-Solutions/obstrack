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

    public function update()
    {
        $user_id = $this->session('user_id');
        $image = $this->processProfileImage();
        $form = [
            'first_name' => $this->input('first_name'),
            'middle_name' => $this->input('middle_name'),
            'last_name' => $this->input('last_name'),
            'dob' => $this->input('dob'),
            'gender' => $this->input('gender'),
            'email' => $this->input('email'),
            'address' => $this->input('address'),
        ];
        if (!empty($image)) {
            $form['image'] = $image;
        }

        if ($this->user->edit($form, $user_id)) {
            $_SESSION[SYSTEM]['first_name'] = $this->input('first_name');
            $_SESSION[SYSTEM]['middle_name'] = $this->input('middle_name');
            $_SESSION[SYSTEM]['last_name'] = $this->input('last_name');

            if (!empty($image)) {
                $_SESSION[SYSTEM]['image'] = $image;
            }
            $this->session_put('success', 'Successfully updated!');
        } else {
            $this->session_put('error', 'Error occur!');
        }
        $this->redirect('profile');
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

    public function profile()
    {
        $user = $this->user->filter([
            'user_id' => $this->session('user_id')
        ]);
        $this->view('user/profile', [
            'user' => $user[0]
        ]);
    }

    public function logout()
    {
        unset($_SESSION[SYSTEM]);
        session_destroy();
        $this->redirect('home');
    }

    public function processProfileImage()
    {
        $uploadDir = "../public/images/users"; // Target directory for uploads
        $file_image = $this->files("image"); // Retrieve the single file input

        try {
            // Check if the uploaded file exists and has no errors
            if (isset($file_image) && $file_image["error"] === UPLOAD_ERR_OK) {
                $file_tmp = $file_image["tmp_name"];
                $file_name = $file_image["name"];
                $file_type = $file_image["type"];

                // Check if the uploaded file is an image
                if (exif_imagetype($file_tmp) === false) {
                    throw new Exception("Uploaded file is not a valid image.");
                }

                // Extract the file extension
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);

                // Generate a unique filename
                $image = uniqid() . "." . $ext;

                // Full path to save the file
                $target_file = $uploadDir . "/" . $image;

                // Move the uploaded file to the destination directory
                if (move_uploaded_file($file_tmp, $target_file)) {
                    return $image; // Return the filename of the uploaded image
                } else {
                    throw new Exception("Failed to move the uploaded file.");
                }
            } else {
                throw new Exception("No file uploaded or an error occurred during upload.");
            }
        } catch (Exception $e) {
            // Return error message
            return '';
        }
    }
}
