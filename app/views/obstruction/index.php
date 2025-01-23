<?php
$title = "Obstructions Page";
$view = '../app/views/obstruction/layout/index.php';
$user_role = $_SESSION['obstrack']['role'] ?? "";

if($user_role == 'USER'){
    $view = '../app/views/obstruction/layout/mobile.index.php';
    require_once '../app/views/mobile.php';
}else{
    require_once '../app/views/layout.php';
}
