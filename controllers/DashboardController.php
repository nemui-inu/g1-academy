<?php declare(strict_types=1);

require_once 'controllers/Controller.php';
require_once 'models/User.php';
require_once 'models/Database.php';

class DashboardController extends Controller
{
  public static string $dir = 'views/dashboard/dashboard.php';

  public static function index(): void
  {
    Controller::load(self::$dir);
  }
}
