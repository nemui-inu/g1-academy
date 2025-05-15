<?php declare(strict_types=1);

require_once 'controllers/Controller.php';
require_once 'controllers/StudentController.php';
require_once 'models/User.php';
require_once 'models/Student.php';
require_once 'models/Course.php';
require_once 'models/Database.php';

class DashboardController extends Controller
{
  public static string $dir = 'views/dashboard/dashboard.php';

  public static function index(): void
  {
    $_SESSION['page'] = 'dashboard';
    $_SESSION['path'] = [
      'Dashboard' => '/group1/dashboard',
      'Overview' => '/group1/dashboard'
    ];
    Controller::load(self::$dir);
  }

  public static function getConnection(): PDO
  {
    $db = new Database();
    return $db->getConnection();
  }

  public static function getStudentCount(): int
  {
    $result = StudentController::fetchStudents('active');
    return count($result);
  }

  public static function getCourseCount(): int
  {
    $result = Course::all();
    return count($result);
  }

  public static function getStudentByYear(): array
  {
    $db = self::getConnection();
    $stmt = $db->prepare("SELECT year_level, COUNT(*) as count FROM students where status='active' GROUP BY year_level ORDER BY year_level ASC;");
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function getUserCount(string $userType): int
  {
    $db = self::getConnection();
    $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE role = :userType;');
    $stmt->bindParam(':userType', $userType);
    $stmt->execute();
    return (int) $stmt->fetchColumn();
  }
}
