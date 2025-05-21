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

  public static function view(): void
  {
    $id = $_GET['id'] ?? null;
    $name = self::getInstructorName($id);

    $_SESSION['page'] = 'instructors';
    $_SESSION['path'] = [
      'Instructors' => '/group1/instructors',
      $name => '/group1/instructor-view?id=' . $id,
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once 'views/instructors/view.php';
    require_once 'layout/components/frame_foot.php';
    echo '<script src="public/js/instructorsData.js"></script>';
    require_once 'layout/footer.php';
  }

  public static function edit(): void
  {
    $id = $_GET['id'] ?? null;
    $name = self::getInstructorName($id);

    $_SESSION['page'] = 'instructors';
    $_SESSION['path'] = [
      'Instructors' => '/group1/instructors',
      'Edit ' . $name => '/group1/instructor-edit?id=' . $id,
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once 'views/instructors/edit.php';
    require_once 'layout/components/frame_foot.php';
    echo '<script src="public/js/instructorsData.js"></script>';
    require_once 'layout/footer.php';
  }

  public static function update(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      self::setUserConnection();

      $id = $_POST['user_id'];

      $data = [
        'name' => $_POST['first_name'] . ' ' . $_POST['last_name'],
        'email' => $_POST['email'],
      ];

      $instructor = new User(User::find($id));

      $instructor->update($data);

      header('Location: /group1/instructors');
    } else {
      echo 'Invalid Request.';
    }
  }

  public static function setUserConnection(): void
  {
    $db = new Database();
    $conn = $db->getConnection();

    User::setConnection($conn);
  }

  public static function fetchInstructors(string $status): array
  {
    self::setUserConnection();

    $all = User::all();
    $results = [];

    foreach ($all as $key) {
      if (strtolower($key->role) != 'instructor') {
        continue;
      }
      if (strtolower($status) != strtolower($key->status) && strtolower($status) != 'all') {
        continue;
      }

      $results[] = $key;
    }

    $rowData = array_map(function ($result) {
      return [
        'id' => $result->user_id,
        'name' => $result->name,
        'email' => $result->email,
        'role' => $result->role,
        'status' => $result->status,
        'updated_at' => $result->updated_at,
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

  public static function getInstructorName($id): string
  {
    self::setUserConnection();

    $instructors = self::fetchInstructors('active');

    foreach ($instructors as $key => $instructor) {
      if ($instructor['id'] == $id) {
        return $instructor['name'];
      }
    }
  }

  public static function findInstructor($id): array
  {
    self::setUserConnection();

    $instructors = self::fetchInstructors('active');

    foreach ($instructors as $key => $instructor) {
      if ($instructor['id'] == $id) {
        return $instructor;
      }
    }
  }

  public static function deactivate(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      self::setUserConnection();

      $id = $_GET['id'];

      $instructor = new User(User::find($id));

      $data = [
        'status' => 'Inactive',
      ];

      $instructor->update($data);

      header('Location: /group1/instructors');
    } else {
      echo 'Invalid request.';
    }
  }

  public static function restoreInstructor(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      self::setUserConnection();

      $id = $_GET['id'];

      $instructor = new User(User::find($id));

      $data = [
        'status' => 'Active',
      ];

      $instructor->update($data);

      header('Location: /group1/archive');
    } else {
      echo 'Invalid request.';
    }
  }
}
