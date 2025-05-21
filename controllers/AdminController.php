<?php declare(strict_types=1);

require_once 'controllers/Controller.php';

require_once 'models/Database.php';
require_once 'models/User.php';

class AdminController extends Controller
{
  public static string $pageDir = 'views/admins/index.php';

  public static function index(): void
  {
    $_SESSION['page'] = 'admins';
    $_SESSION['path'] = [
      'Admins' => '/group1/admins',
      'Overview' => '/group1/admins',
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once self::$pageDir;
    require_once 'layout/components/frame_foot.php';
    echo '<script src="public/js/activeAdmins.js"></script>';
    require_once 'layout/footer.php';
  }

  public static function setUserConnection(): void
  {
    $db = new Database();
    $conn = $db->getConnection();

    User::setConnection($conn);
  }

  public static function fetchAdmins(string $status): array
  {
    self::setUserConnection();

    $all = User::all();
    $results = [];

    foreach ($all as $key) {
      if (strtolower($key->role) != 'admin') {
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

  public static function findAdmin(int $id): ?array
  {
    self::setUserConnection();

    $admin = User::find($id);

    if ($admin && strtolower($admin['role']) == 'admin') {
      return $admin;
    }

    return null;
  }

  public static function create(): void
  {
    $_SESSION['page'] = 'instructors';
    $_SESSION['path'] = [
      'Admins' => '/group1/admins',
      'Create' => '/group1/admins-create',
    ];
    include 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    include 'views/admins/create.php';
    require_once 'layout/components/frame_foot.php';
    include 'layout/footer.php';
  }

  public static function view(): void
  {
    $id = $_GET['id'] ?? null;
    $admin = self::findAdmin((int) $id);
    $name = $admin['name'];

    $_SESSION['page'] = 'admins';
    $_SESSION['path'] = [
      'Admins' => '/group1/admins',
      $name => '/group1/admins-view?id=' . $id,
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once 'views/admins/view.php';
    require_once 'layout/components/frame_foot.php';
    require_once 'layout/footer.php';
  }

  public static function edit(): void
  {
    $id = $_GET['id'] ?? null;
    $instructor = self::findAdmin((int) $id);
    $name = $instructor['name'];

    $_SESSION['page'] = 'admins';
    $_SESSION['path'] = [
      'Admins' => '/group1/admins',
      'Edit ' . $name => '/group1/admin-edit?id=' . $id,
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once 'views/admins/edit.php';
    require_once 'layout/components/frame_foot.php';
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

      header('Location: /group1/admins');
    } else {
      echo 'Invalid Request.';
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

      header('Location: /group1/admins');
    } else {
      echo 'Invalid request.';
    }
  }

  public static function restoreAdmin(): void
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
