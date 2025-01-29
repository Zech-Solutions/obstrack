<?php
$title = "Home Page";
$view = '../app/views/home/layout/index.php';

$locations = [];
foreach ($obstructions as $obstruction) {
    if(in_array($obstruction['status'], ['REJECTED', 'COMPLETED']))
        continue;
    $location = json_decode($obstruction['location'], true);
    if (empty($location)) {
        $location = [
            'lat' => 10.643755048897885,
            'lng' => 122.93992712714316
        ];
    }
    $location['title'] = $obstruction['street'] . ", " . $obstruction['brgy']['name'];
    $location['content'] = date("M d, Y h:i A", strtotime($obstruction['created_at']))  . "<br>" . $obstruction['detail'] . "<br>" . $obstruction['status'];
    $locations[] = $location;
}

// var_dump($_SESSION['obstrack']);
$user_role = $_SESSION['obstrack']['role'] ?? "";
if($user_role == 'USER'){
    $view = '../app/views/home/layout/mobile.index.php';
    require_once '../app/views/mobile.php';
}else{
    require_once '../app/views/layout.php';
}
// require_once '../app/views/layout.php';
