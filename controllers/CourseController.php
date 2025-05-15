<?php declare(strict_types=1);

require_once 'controllers/Controller.php';
require_once 'controllers/StudentController.php';

require_once 'models/Course.php';

class CourseController extends Controller
{
  public static string $pageDir = 'views/courses/index.php';

  public static function index(): void
  {
    $_SESSION['page'] = 'courses';
    $_SESSION['path'] = [
      'Courses' => '/group1/courses',
      'Overview' => '/group1/courses',
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once self::$pageDir;
    require_once 'layout/components/frame_foot.php';
    echo '<script src="public/js/coursesOffered.js"></script>';
    require_once 'layout/footer.php';
  }

  public static function create(): void
  {
    $_SESSION['page'] = 'courses';
    $_SESSION['path'] = [
      'Courses' => '/group1/courses',
      'Create' => '/group1/courses-create',
    ];
    include 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    include 'views/courses/create.php';
    require_once 'layout/components/frame_foot.php';
    include 'layout/footer.php';
  }

  public static function view(): void
  {
    CourseController::setCourseConnection();

    $courses = Course::find($_GET['id']);
    $course_id = $courses->course_id;
    $course_code = $courses->code;
    $course_name = $courses->name;

    $_SESSION['page'] = 'courses';
    $_SESSION['path'] = [
      'Courses' => '/group1/courses',
      $course_name => '/group1/courses-view?id=' . $course_id,
    ];
    include 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    include 'views/courses/view.php';
    require_once 'layout/components/frame_foot.php';
    echo '<script src="public/js/studentEnrolled.js"></script>';
    include 'layout/footer.php';
  }

  public static function edit(): void
  {
    CourseController::setCourseConnection();

    $courses = Course::find($_GET['id']);
    $course_id = $courses->course_id;
    $course_code = $courses->code;
    $course_name = $courses->name;

    $_SESSION['page'] = 'courses';
    $_SESSION['path'] = [
      'Courses' => '/group1/courses',
      'Edit ' . $course_code => '/group1/courses-edit?id=' . $course_id,
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      include 'layout/header.php';
      require_once 'layout/components/frame_head.php';
      include 'views/courses/edit.php';
      require_once 'layout/components/frame_foot.php';
      include 'layout/footer.php';
    } else {
      echo 'Invalid Request.';
    }
  }

  public static function updateStudent(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      self::setCourseConnection();

      $course_id = $_POST['course_id'];

      $data = [
        'code' => $_POST['code'],
        'name' => $_POST['name'],
      ];

      $course = Course::find($course_id);
      $course->update($course_id, $data);
      $course->save();

      header('Location: /group1/courses');
    } else {
      echo 'Invalid Request.';
    }
  }

  public static function add(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      self::setCourseConnection();

      $data = [
        'name' => $_POST['name'],
        'code' => $_POST['code'],
      ];

      Course::create($data);
      header('Location: /group1/courses');
    } else {
      echo 'Invalid Request.';
    }
  }

  public static function delete(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      self::setCourseConnection();

      $courses = self::getCourses();

      $courseToDelete = Course::find($_GET['id']);

      $canDelete = true;

      foreach ($courses as $course) {
        if ($course['code'] == $courseToDelete->code && $course['enrolled'] != 0) {
          echo 'You cannot delete this course. There are students enrolled. ';
          echo '<a href="/group1/courses">Go back.</a>';
          $canDelete = false;
          exit;
        }
      }

      if ($canDelete) {
        $courseToDelete->delete();
      }

      header('Location: /group1/courses');
    } else {
      echo 'Invalid Request.';
    }
  }

  public static function setCourseConnection(): void
  {
    $db = new Database();
    $conn = $db->getConnection();

    Course::setConnection($conn);
  }

  public static function identifyCourse(int $courseId): string
  {
    $course = '';
    switch ($courseId) {
      case 1:
        $course = 'BSIT';
        break;
      case 2:
        $course = 'BSCS';
        break;
      default:
        $course = 'Unenrolled';
        break;
    }

    return $course;
  }

  public static function getCourses(): array
  {
    self::setCourseConnection();
    $results = Course::all();

    $students = StudentController::fetchStudents('active');

    $courses = [];

    // (!) Map courses into an array
    foreach ($results as $result) {
      $courses[$result->code] = 0;
    }

    // (!) Count students enrolled in a course
    foreach ($students as $student) {
      $courses[$student['course']] += 1;
    }

    $rowData = array_map(function ($result) use ($courses) {
      return [
        'id' => $result->course_id,
        'code' => $result->code,
        'name' => $result->name,
        'enrolled' => $courses[$result->code],
      ];
    }, $results);

    return $rowData;
  }
}
