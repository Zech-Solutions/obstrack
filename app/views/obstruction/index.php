<?php
$title = "Obstructions Page";
$index_php = $_SESSION[SYSTEM]['role'] == 'USER' ? "index" : "index-admin";
$view = '../app/views/obstruction/layout/' . $index_php . ".php";

require_once '../app/views/layout.php';
