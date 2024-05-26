<?php
$title = "Barangays Page";
$view = '../app/views/brgy/layout/create.php';
$badge_success = '';
if (isset($_SESSION[SYSTEM]['success'])) {
    $badge_success = "<badge class='alert alert-success'>" . $_SESSION[SYSTEM]['success'] . "</badge>";
}
$badge_error = '';
if (isset($_SESSION[SYSTEM]['error'])) {
    $badge_error = "<badge class='alert alert-danger'>" . $_SESSION[SYSTEM]['error'] . "</badge>";
}

unset($_SESSION[SYSTEM]['error']);
unset($_SESSION[SYSTEM]['success']);
require_once '../app/views/layout.php';
