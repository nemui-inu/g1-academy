<?php declare(strict_types=1);

class Controller
{
  public static function load(string $dir): void
  {
    if (!isset($_SESSION['user']) && $dir !== 'views/auth/login.php') {
      header('Location: /group1/login');
      exit;
    }
    require 'layout/header.php';
    require $dir;
    require 'layout/footer.php';
  }
}
