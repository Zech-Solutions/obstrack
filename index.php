<?php
session_start();
require_once 'app/globals.php';
if (isset($_SESSION[SYSTEM]['user_id'])) {
    header("Location: " . URL_PUBLIC);
}

$badge_success = '';
if (isset($_SESSION[SYSTEM]['success'])) {
    $badge_success = "<badge class='alert alert-success row'>" . $_SESSION[SYSTEM]['success'] . "</badge>";
}
$badge_error = '';
if (isset($_SESSION[SYSTEM]['error'])) {
    $badge_error = "<badge class='alert alert-danger row'>" . $_SESSION[SYSTEM]['error'] . "</badge>";
}

unset($_SESSION[SYSTEM]['error']);
unset($_SESSION[SYSTEM]['success']);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Obstrack - Login</title>

    <!-- Custom fonts for this template-->
    <!-- <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="<?= URL_PUBLIC ?>/css/sb-admin-2.min.css">
    <style>
        :root {
            --login-logo: url("<?= URL_PUBLIC ?>/images/login_logo.png");
        }

        .bg-gradient-etally {
            background-color: #056f39;
            background-image: linear-gradient(180deg, #056f39 1%, #3faf53 58%);
            background-size: cover;
            background-repeat: no-repeat;
        }

        .bg-login-image-etally {
            background-image: var(--login-logo);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="bg-gradient-etally">

    <div class="container mt-5">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-block bg-login-image-etally img-container" id="image-container"></div>
                            <div class="col-lg-7" id="form-container">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bacolod Road Obstruction Incident Report Management Application</h1>
                                    </div>
                                    <form id="login-form" class="user" action="<?= URL_PUBLIC ?>/login" method="POST">
                                        <div class="form-group">
                                            <input name="username" type="username" class="form-control form-control-user"
                                                id="username" aria-describedby="emailHelp"
                                                placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control form-control-user"
                                                id="password" placeholder="Password" required>
                                        </div>
                                        <div class="bd-example login-response">
                                            <?= $badge_error ?>
                                            <?= $badge_success ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <!-- <p class="mt-3">Don't have an account? <a href="#" onclick="toggleForm()">Sign Up</a></p> -->
                                    </form>
                                    <form action="<?= URL_PUBLIC ?>/register" method="POST" id="signup-form" style="display: none;">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="signup-firstname">First Name</label>
                                                <input type="text" class="form-control form-control-user" id="signup-firstname" placeholder="Enter first name" name="first_name" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="signup-middlename">Middle Name</label>
                                                <input type="text" class="form-control" id="signup-middlename" placeholder="Enter middle name" name="middle_name">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="signup-lastname">Last Name</label>
                                                <input type="text" class="form-control" id="signup-lastname" placeholder="Enter last name" name="last_name" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="signup-birthdate">Birthdate</label>
                                                <input type="date" class="form-control" id="signup-birthdate" name="dob" max="<?= date('Y-m-d') ?>" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="signup-gender">Gender</label>
                                                <select class="form-control" id="signup-gender" name="gender" required>
                                                    <option value="" disabled selected>Select gender</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="signup-address">Address</label>
                                            <textarea class="form-control" id="signup-address" placeholder="Enter address" rows="2" name="address" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="signup-username">Username</label>
                                            <input type="text" class="form-control" id="signup-username" placeholder="Enter username" name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="signup-password">Password</label>
                                            <input type="password" class="form-control" id="signup-password" placeholder="Password" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Sign Up
                                        </button>
                                        <p class="mt-3">Already have an account? <a href="#" onclick="toggleForm()">Log In</a></p>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Bacolod Road Obstruction Incident Report Management Application &copy; 2023</span>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleForm() {
            const loginForm = document.getElementById('login-form');
            const signupForm = document.getElementById('signup-form');
            const imageContainer = document.getElementById('image-container');
            const formContainer = document.getElementById('form-container');
            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                signupForm.style.display = 'none';
                imageContainer.style.display = 'block';
                formContainer.classList.remove('col-lg-12');
                formContainer.classList.add('col-lg-7');
            } else {
                loginForm.style.display = 'none';
                signupForm.style.display = 'block';
                imageContainer.style.display = 'none';
                formContainer.classList.remove('col-lg-7');
                formContainer.classList.add('col-lg-12');
            }
        }
    </script>
</body>

</html>