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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup & Login Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= URL_PUBLIC ?>/vendor/bootstrap/bootstrap.min.css">
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f7f7f7;
        }

        .form-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 800px;
            width: 100%;
        }

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
        }

        .form-content {
            flex: 1;
            padding: 20px;
            width: 100%;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-content h2 {
            margin-bottom: 20px;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }

        .btn-social i {
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .form-box {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .image-container,
            .form-content {
                width: 100%;
            }

            .form-content {
                padding: 20px 0;
            }
        }
    </style>
</head>

<body>

    <div class="container form-container">
        <div class="form-box">
            <div class="image-container" id="image-container">
                <!-- Replace the src with your traffic incidents image URL -->
                <img src="https://via.placeholder.com/100x100.png?text=Traffic+Incidents" alt="Traffic Incidents Image">
            </div>
            <div class="form-content">
                <form id="login-form" action="<?= URL_PUBLIC ?>/login" method="POST">
                    <h2>Login</h2>
                    <div class="form-group">
                        <label for="login-username">Username</label>
                        <input type="text" class="form-control" id="login-username" placeholder="Enter username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" class="form-control" id="login-password" placeholder="Password" name="password" required>
                    </div>
                    <div class="form-group">
                        <?=$badge_error?>
                        <?=$badge_success?>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="login-remember">
                        <label class="form-check-label" for="login-remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    <p class="mt-3">Don't have an account? <a href="#" onclick="toggleForm()">Sign Up</a></p>
                    <p><a href="#">Forgot password?</a></p>
                </form>

                <form action="<?= URL_PUBLIC ?>/register" method="POST" id="signup-form" style="display: none;">
                    <h2>Sign Up</h2>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="signup-firstname">First Name</label>
                            <input type="text" class="form-control" id="signup-firstname" placeholder="Enter first name" name="first_name" required>
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
                            <input type="date" class="form-control" id="signup-birthdate" name="dob" max="<?=date('Y-m-d')?>" required>
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
                    <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    <p class="mt-3">Already have an account? <a href="#" onclick="toggleForm()">Log In</a></p>
                </form>
            </div>
            <div class="form-footer">
                <p>Bacolod Road Obstruction Incident Report Management Application</p>
            </div>
        </div>
    </div>

    <!-- Font Awesome for social icons -->
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    <!-- Bootstrap JS and jQuery -->
    <script src="<?= URL_PUBLIC ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= URL_PUBLIC ?>/vendor/popper/popper.min.js"></script>
    <script src="<?= URL_PUBLIC ?>/vendor/bootstrap/bootstrap.min.js"></script>

    <script>
        function toggleForm() {
            const loginForm = document.getElementById('login-form');
            const signupForm = document.getElementById('signup-form');
            const imageContainer = document.getElementById('image-container');
            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                signupForm.style.display = 'none';
                imageContainer.style.display = 'flex';
            } else {
                loginForm.style.display = 'none';
                signupForm.style.display = 'block';
                imageContainer.style.display = 'none';
            }
        }
    </script>

</body>

</html>