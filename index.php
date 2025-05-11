<?php declare(strict_types=1);

require_once 'router/Router.php';
require_once 'controllers/LoginController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/StudentController.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$folder = '/group1';
$path = str_replace($folder, '', $path);

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

Router::add('/', fn() => LoginController::index());
Router::add('/login', function () {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    LoginController::login();
  } else {
    LoginController::index();
  }
});
Router::add('/logout', fn() => LoginController::logout());

Router::add('/dashboard', fn() => DashboardController::index());

Router::add('/students-create', fn() => StudentController::create());
Router::add('/students-addstudent', fn() => StudentController::add());
Router::add('/students', fn() => StudentController::index());
Router::add('/studenttable', fn() => require 'ajax.php');  // (<-) Ajax Route

Router::dispatch($path);
