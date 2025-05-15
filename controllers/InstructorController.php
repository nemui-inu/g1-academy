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
    echo '<script src="public/js/instructorsData.js"></script>';
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

    $results = User::all();

    $rowData = array_map(function ($result) {
      return [
        'id' => $result->user_id,
        'name' => $result->name,
        'email' => $result->email,
        'role' => $result->role,
      ];
    }, $results);

    return $rowData;
  }

  public static function create(): void
  {
    $_SESSION['page'] = 'instructors';
    $_SESSION['path'] = [
      'Instructors' => '/group1/instructors',
      'Create' => '/group1/instrucors-create',
    ];
    include 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    include 'views/instructors/create.php';
    require_once 'layout/components/frame_foot.php';
    include 'layout/footer.php';
  }

  public static function add(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      self::setUserConnection();

      $data = [
        'name' => $_POST['first_name'] . ' ' . $_POST['last_name'],
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
        'role' => $_POST['role'],
        'status' => $_POST['status'],
      ];

      User::create($data);
      header('Location: /group1/instructors');
    }
  }
}
