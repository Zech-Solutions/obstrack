<?php
$title = "Obstructions Page";
$view = '../app/views/obstruction/layout/create.php';

$user_role = $_SESSION['obstrack']['role'] ?? "";

if($user_role == 'USER'){
    $view = '../app/views/obstruction/layout/mobile.create.php';
    require_once '../app/views/mobile.php';
}else{
    require_once '../app/views/layout.php';
}