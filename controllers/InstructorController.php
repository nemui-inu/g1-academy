<?php declare(strict_types=1);

require_once 'controllers/Controller.php';

require_once 'models/Database.php';
require_once 'models/User.php';

class InstructorController extends Controller
{
  public static string $pageDir = 'views/instructors/index.php';

  public static function index(): void
  {
    $_SESSION['page'] = 'instructors';
    $_SESSION['path'] = [
      'Instructors' => '/group1/instructors',
      'Overview' => '/group1/instructors',
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once self::$pageDir;
    require_once 'layout/components/frame_foot.php';
    echo '<script src="public/js/subjectsOffered.js"></script>';
    require_once 'layout/footer.php';
  }

  public static function setUserConnection(): void
  {
    $db = new Database();
    $conn = $db->getConnection();

    User::setConnection($conn);
  }

  public static function fetchInstructors(): array
  {
    self::setUserConnection();

    $result = User::all();

    $rowData = [];

    return $rowData;
  }
}
