<?php declare(strict_types=1);

require_once 'controllers/Controller.php';
require_once 'controllers/StudentController.php';

class ArchiveController extends Controller
{
  public static string $pageDir = 'views/archive/index.php';

  public static function index(): void
  {
    $_SESSION['page'] = 'archive';
    $_SESSION['path'] = [
      'Archive' => '/group1/archive',
      'Overview' => '/group1/archive',
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once self::$pageDir;
    require_once 'layout/components/frame_foot.php';
    require_once 'layout/footer.php';
  }

  public static function restoreStudent(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $id = $_GET['id'];
      unset($_GET['id']);

      StudentController::setStudentConnection();

      (array) $data = array('status' => 'active');

      $student = new Student(Student::findByStudentId($id));
      $student->update($data);
      $student->save();

      header('Location: /group1/archive');
    } else {
      echo 'Invalid request.';
    }
  }
}
