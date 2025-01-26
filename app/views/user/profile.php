<?php
$title = "Users Page";
$view = '../app/views/user/layout/profile.php';
$badge_success = '';
if (isset($_SESSION[SYSTEM]['success'])) {
    $badge_success = "<badge class='alert alert-success col-md-6'>" . $_SESSION[SYSTEM]['success'] . "</badge>";
}
$badge_error = '';
if (isset($_SESSION[SYSTEM]['error'])) {
    $badge_error = "<badge class='alert alert-danger col-md-6'>" . $_SESSION[SYSTEM]['error'] . "</badge>";
}

unset($_SESSION[SYSTEM]['error']);
unset($_SESSION[SYSTEM]['success']);
require_once '../app/views/layout.php';
