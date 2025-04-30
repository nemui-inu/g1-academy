<?php declare(strict_types=1);

require 'router/Router.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$folder = '/group1';
$path = str_replace($folder, '', $path);

$router = new Router();

$router->add('/', fn() => (isset($_SESSION['user'])) ? require 'views/dashboard.php' : require 'views/auth/login.php');
$router->add('/login', fn() => require 'views/auth/login.php');

$router->dispatch($path);
