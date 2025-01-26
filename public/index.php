<?php
session_start();
require_once '../app/globals.php';

require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/View.php';
require_once '../app/core/Router.php';

// require_once '../app/controllers/HomeController.php';
// require_once '../app/controllers/UserController.php';
// require_once '../app/controllers/ApiController.php';

date_default_timezone_set("Asia/Manila");

$router = new Router();

// Web routes
$router->get('', 'HomeController@index');
$router->get('home', 'HomeController@index');

// Obstruction Types
$router->get('obstruction-types', 'ObstructionTypeController@index');
$router->get('obstruction-types/create', 'ObstructionTypeController@create');
$router->post('obstruction-types/store', 'ObstructionTypeController@store');
$router->get('obstruction-types/{obstruction_type_id}/edit', 'ObstructionTypeController@edit');
$router->post('obstruction-types/{obstruction_type_id}', 'ObstructionTypeController@update');
$router->post('obstruction-types/data/destroy', 'ObstructionTypeController@destroy');

// Barangays
$router->get('brgys', 'BarangayController@index');
$router->get('brgys/create', 'BarangayController@create');
$router->post('brgys/store', 'BarangayController@store');
$router->get('brgys/{brgy_id}/edit', 'BarangayController@edit');
$router->post('brgys/{brgy_id}', 'BarangayController@update');
$router->post('brgys/data/destroy', 'BarangayController@destroy');


// Obstructions
$router->get('obstructions', 'ObstructionController@index');
$router->get('obstructions/create', 'ObstructionController@create');
$router->get('obstructions/show', 'ObstructionController@show');
$router->get('obstructions/{obstruction_id}/to-verify', 'ObstructionController@toVerify');
$router->get('obstructions/{obstruction_id}/action', 'ObstructionController@action');
$router->get('obstructions/{obstruction_id}/request', 'ObstructionController@request');
$router->post('obstructions/action/store', 'ObstructionController@storeAction');
$router->post('obstructions/request/store', 'ObstructionController@storeRequest');
$router->post('obstructions/request/update', 'ObstructionController@updateRequest');
$router->post('obstructions/store', 'ObstructionController@store');
$router->get('obstructions/requests', 'ObstructionController@indexRequest');

// USER
$router->post('register', 'UserController@register');
$router->get('profile', 'UserController@profile');
$router->post('profile/update', 'UserController@update');
$router->post('login', 'UserController@login');
$router->get('logout', 'UserController@logout');
$router->get('users', 'UserController@index');
$router->get('users/create', 'UserController@create');
$router->post('users/store', 'UserController@store');

// Notifications
$router->get('notifications', 'NotificationController@index');

// API routes
$router->get('api/data', 'ApiController@getData');
$router->get('api/login', 'ApiController@login');

$router->dispatch();

function timeAgo($datetime, $full = false)
{
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = [
        'y' => 'yr',
        'm' => 'mo',
        'w' => 'wk',
        'd' => 'd',
        'h' => 'hr',
        'i' => 'min',
        's' => 'sec',
    ];
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function badgeStatus($status){
    if ($status == 'COMPLETED') {
        $status_badge = '<span class="badge badge-success">Resolved</span>';
    } else if ($status == 'WIP') {
        $status_badge = '<span class="badge badge-warning">Work in Progress</span>';
    } else if ($status == 'VERIFIED') {
        $status_badge = '<span class="badge badge-success">Verified</span>';
    } else if ($status == 'REJECTED') {
        $status_badge = '<span class="badge badge-danger">Rejected</span>';
    } else {
        $status_badge = '<span class="badge badge-danger">Pending</span>';
    }

    return $status_badge;
}
