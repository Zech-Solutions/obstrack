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
$router->get('home/{id}/{old}', 'HomeController@show');

// Obstruction Types
$router->get('obstruction-types', 'ObstructionTypeController@index');
$router->get('obstruction-types/create', 'ObstructionTypeController@create');
$router->post('obstruction-types/store', 'ObstructionTypeController@store');
$router->get('obstruction-types/{obstruction_type_id}/edit', 'ObstructionTypeController@edit');
$router->post('obstruction-types/{obstruction_type_id}', 'ObstructionTypeController@update');


// Obstructions
$router->get('obstructions', 'ObstructionController@index');
$router->get('obstructions/create', 'ObstructionController@create');
$router->post('obstructions/store', 'ObstructionController@store');

// USER
$router->post('register', 'UserController@register');
$router->post('login', 'UserController@login');
$router->get('logout', 'UserController@logout');
$router->get('users', 'UserController@index');


// API routes
$router->get('api/data', 'ApiController@getData');

$router->dispatch();


if (!isset($_SESSION[SYSTEM]['user_id'])) {
    header("Location: " . URL);
}
