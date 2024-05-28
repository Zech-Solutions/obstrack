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
$router->get('obstructions/{obstruction_id}/action', 'ObstructionController@action');
$router->get('obstructions/{obstruction_id}/request', 'ObstructionController@request');
$router->post('obstructions/action/store', 'ObstructionController@storeAction');
$router->post('obstructions/request/store', 'ObstructionController@storeRequest');
$router->post('obstructions/request/update', 'ObstructionController@updateRequest');
$router->post('obstructions/store', 'ObstructionController@store');
$router->get('obstructions/requests', 'ObstructionController@indexRequest');

// USER
$router->post('register', 'UserController@register');
$router->post('login', 'UserController@login');
$router->get('logout', 'UserController@logout');
$router->get('users', 'UserController@index');
$router->get('users/create', 'UserController@create');
$router->post('users/store', 'UserController@store');


// API routes
$router->get('api/data', 'ApiController@getData');

$router->dispatch();


if (!isset($_SESSION[SYSTEM]['user_id'])) {
    header("Location: " . URL);
}
