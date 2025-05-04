<?php declare(strict_types=1);

class Controller
{
  public static function load(string $route): void
  {
    if ($_SESSION['user'] ?? null) {
      header('Location: ' . $route);
      exit;
    } else {
      require 'layout/header.php';
      require 'views/auth/login.php';
      require 'layout/footer.php';
    }
  }
}
