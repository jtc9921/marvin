<?php

require '../vendor/autoload.php';

use Pux\Mux;
use Pux\Executor;

define('BASE_DIR', realpath(__DIR__).'/..');

$router = new Mux;
$router->post('/', ['Marvin\Controllers\MainController', 'postAction']);

$route = $router->dispatch($_SERVER['REQUEST_URI']);

echo Executor::execute($route);
