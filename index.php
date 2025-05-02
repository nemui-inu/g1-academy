<?php declare(strict_types=1);

require 'router/Router.php';
require 'controllers/LoginController.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$folder = '/group1';
$path = str_replace($folder, '', $path);

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

Router::add('/', fn() => (isset($_SESSION['user'])) ? require 'views/dashboard/test.php' : LoginController::index());
Router::add('/login', function () {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    LoginController::login();
  } else {
    LoginController::index();
  }
});
Router::add('/logout', fn() => LoginController::logout());
Router::add('/dashboard', fn() => (isset($_SESSION['user'])) ? require 'views/dashboard/test.php' : LoginController::index());

Router::dispatch($path);
