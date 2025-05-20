<?php declare(strict_types=1);

  require_once 'controllers/Controller.php';
  require_once 'controllers/StudentController.php';
  require_once 'models/User.php';
  require_once 'models/Student.php';
  require_once 'models/Course.php';
  require_once 'models/Model.php';
  require_once 'models/Database.php';
  require_once 'models/Dashboard.php';

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

      // Get the PDO connection first
      $pdo = self::getConnection();

      // Set the connection to the Model
      Model::setConnection($pdo);

      $dashboard = new Dashboard($pdo);

      $user_role = $_SESSION['auth']['role'] ?? 'guest';
      $dashboard->loadDashboardData($user_role);

      $data = [
          'total_students'         => $dashboard->total_students,
          'total_instructors'      => $dashboard->total_instructors,
          'total_courses'          => $dashboard->total_courses,
          'total_subjects'         => $dashboard->total_subjects,
          'students_per_year'      => $dashboard->students_per_year_level,
          'top_courses'            => $dashboard->top_courses,
          'subjects'               => $dashboard->subjects,
          'instructors'            => $dashboard->instructors,
      ];

      if ($user_role === 'super-admin') {
          $data['total_admins'] = $dashboard->total_admins;
      }

      self::load(self::$dir, $data);
  }

    public static function getConnection(): PDO
    {
        $db = new Database();
        return $db->getConnection();
    }

    // Optional utilities for individual dashboard elements
    public static function getStudentCount(): int
    {
        return count(StudentController::fetchStudents('active'));
    }

    public static function getCourseCount(): int
    {
        return count(Course::all());
    }

    public static function getStudentByYear(): array
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT year_level, COUNT(*) as count FROM students WHERE status = 'active' GROUP BY year_level ORDER BY year_level ASC;");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getUserCount(string $role): int
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = :role;");
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public static function getSubjectCount(): int
    {
        $db = self::getConnection();
        $dashboard = new Dashboard($db);
        return (int) $dashboard->getTotal('subjects');
    }

    public static function getPendingGradingDetails($instructor_id): array
    {
        $db = self::getConnection();
        $dashboard = new Dashboard($db);
        return $dashboard->getPendingGradingDetails($instructor_id);
    }

    public static function getInstructorSchedules($instructor_id): array
    {
        $db = self::getConnection();
        $dashboard = new Dashboard($db);
        return $dashboard->getInstructorSchedules($instructor_id);
    }
}
