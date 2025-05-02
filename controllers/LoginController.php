<?php declare(strict_types=1);

require_once 'models/User.php';
require_once 'models/Database.php';

class LoginController
{
  public static function index(): void
  {
    if ($_SESSION['user'] ?? null) {
      header('Location: /group1/dashboard');
      exit;
    }
    require 'layout/header.php';
    require 'views/auth/login.php';
    require 'layout/footer.php';
  }

  public static function login(): void
  {
    if ($_SESSION['user'] ?? null) {
      header('Location: /group1/dashboard');
      exit;
    }

    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    $database = new Database();
    $conn = $database->getConnection();
    User::setConnection($conn);

    $user = User::findByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user'] = $user;
      header('Location: /group1/dashboard');
      exit;
    } else {
      $_SESSION['error'] = 'Invalid email or password';
      header('Location: /group1/login');
    }
  }

  public static function logout(): void
  {
    session_start();
    session_destroy();
    header('Location: /group1/login');
    exit;
  }
}
