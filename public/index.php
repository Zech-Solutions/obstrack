<?php
require_once '../app/globals.php';

require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/View.php';
require_once '../app/core/Router.php';

require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/ApiController.php';

$router = new Router();

// Web routes
$router->get('', 'HomeController@index');
$router->get('home', 'HomeController@index');

// API routes
$router->get('api/data', 'ApiController@getData');

$router->dispatch();
