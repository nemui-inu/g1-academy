<?php declare(strict_types=1);

require 'router/Router.php';
require 'controllers/LoginController.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$folder = '/group1';
$path = str_replace($folder, '', $path);

Router::add('/', fn() => (isset($_SESSION['user'])) ? require 'views/dashboard.php' : LoginController::index());
Router::add('/login', fn() => ($_SERVER['REQUEST_METHOD'] === 'POST') ? LoginController::login() : LoginController::index());
Router::add('/logout', fn() => LoginController::logout());

Router::dispatch($path);
