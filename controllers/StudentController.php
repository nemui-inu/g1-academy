<?php declare(strict_types=1);

require_once 'controllers/Controller.php';
require_once 'models/Student.php';
require_once 'models/Course.php';
require_once 'models/Database.php';

class StudentController extends Controller
{
  public static string $dir = 'views/students/index.php';

  public static function setStudentConnection(): void
  {
    $db = new Database();
    $conn = $db->getConnection();

    Student::setConnection($conn);
  }

  public static function index(): void
  {
    $_SESSION['page'] = 'students';
    $_SESSION['path'] = [
      'Students' => '/group1/students',
      'Overview' => '/group1/students',
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once 'views/students/index.html';
    require_once 'layout/components/frame_foot.php';
    echo '<script src="public/js/activeStudent.js"></script>';
    require_once 'layout/footer.php';
  }

  public static function view(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      self::setStudentConnection();

      $_SESSION['view_user'] = Student::findByStudentId($_GET['id']);

      $_SESSION['page'] = 'students';
      $_SESSION['path'] = [
        'Students' => '/group1/students',
        $_SESSION['view_user']['name'] => '/group1/students-view',
      ];

      include 'layout/header.php';
      require_once 'layout/components/frame_head.php';
      include 'views/students/view.php';
      require_once 'layout/components/frame_foot.php';
      include 'layout/footer.php';
    } else {
      echo 'Invalid Request.';
    }
  }

  public static function create(): void
  {
    $_SESSION['page'] = 'students';
    $_SESSION['path'] = [
      'Students' => '/group1/students',
      'Create' => '/group1/students-create',
    ];
    include 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    include 'views/students/create.php';
    require_once 'layout/components/frame_foot.php';
    include 'layout/footer.php';
  }

  public static function edit(): void
  {
    $_SESSION['page'] = 'students';
    $_SESSION['path'] = [
      'Students' => '/group1/students',
      'Edit' => '/group1/students-edit',
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      self::setStudentConnection();

      $_SESSION['edit_user'] = Student::findByStudentId($_GET['id']);

      include 'layout/header.php';
      require_once 'layout/components/frame_head.php';
      include 'views/students/edit.php';
      require_once 'layout/components/frame_foot.php';
      include 'layout/footer.php';
    } else {
      echo 'Invalid Request.';
    }
  }

  public static function getYearLevel(int $year): string
  {
    $yearLevel = '';
    switch ($year) {
      case 1:
        $yearLevel = 'First Year';
        break;
      case 2:
        $yearLevel = 'Second Year';
        break;
      case 3:
        $yearLevel = 'Third Year';
        break;
      case 4:
        $yearLevel = 'Fourth Year';
        break;
      default:
        $yearLevel = 'Unenrolled';
        break;
    }
    return $yearLevel;
  }

  public static function editStudent(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      self::setStudentConnection();

      $data = [
        'name' => $_POST['firstName'] . ' ' . $_POST['lastName'],
        'gender' => $_POST['gender'],
        'birthdate' => $_POST['birthdate'],
        'course_id' => $_POST['course'],
        'year_level' => $_POST['yearLevel'],
        'status' => $_POST['status'],
      ];

      $student = Student::find($_POST['id']);
      $student->update($data);
      $student->save();

      header('Location: /group1/students');
    } else {
      echo 'Invalid Request.';
    }
  }

  public static function getLastId(): array
  {
    self::setStudentConnection();

    if (!$result = Student::all()) {
      return $ids = [
        'id' => '1',
        'student_id' => 'GS-0001',
      ];
    }
    $lastId = (int) $result[count($result) - 1]->id;
    $currentId = $lastId + 1;

    $studentId = 'GS-';

    if (++$lastId < 10) {
      $studentId .= '000';
    } else if ($currentId > 9 && $currentId < 100) {
      $studentId .= '00';
    } else if ($currentId > 99 && $currentId < 1000) {
      $studentId .= '0';
    }

    $studentId .= (string) $currentId;

    $last_ids = [
      'id' => $currentId,
      'student_id' => $studentId,
    ];

    return $last_ids;
  }

  public static function add(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      self::setStudentConnection();

      $ids = self::getLastId();

      $id = $ids['id'];
      $studentId = $ids['student_id'];

      $data = [
        'student_id' => $studentId,
        'name' => $_POST['firstName'] . ' ' . $_POST['lastName'],
        'gender' => $_POST['gender'],
        'birthdate' => $_POST['birthdate'],
        'course_id' => $_POST['course'],
        'year_level' => $_POST['yearLevel'],
        'status' => $_POST['status']
      ];

      Student::create($data);
      header('Location: /group1/students');
    }
  }

  public static function getConnection(): PDO
  {
    $db = new Database();
    return $db->getConnection();
  }

  public static function fetchByCourseId(): array
  {
    $students = self::fetchStudents('active');

    $courseCode = $_SESSION['enrolled_table'];
    unset($_SESSION['enrolled_table']);

    $rowData = [];

    foreach ($students as $student) {
      if ($student['course'] == $courseCode) {
        $rowData[] = $student;
      }
    }

    return $rowData;
  }

  public static function fetchStudents(string $status): array
  {
    self::setStudentConnection();

    $results = Student::all();
    $students = [];

    foreach ($results as $result) {
      if (strtolower($result->status) != $status) {
        continue;
      }

      switch ($result->year_level) {
        case '1':
          $result->year_level = '1st Year';
          break;
        case '2':
          $result->year_level = '2nd Year';
          break;
        case '3':
          $result->year_level = '3rd Year';
          break;
        case '4':
          $result->year_level = '4th Year';
          break;
        default:
          $result->year_level = 'Irregular Status';
          break;
      }

      $students[] = $result;
    }

    $courses = Course::getCourses();
    $courseMap = [];
    foreach ($courses as $course) {
      $courseMap[$course['course_id']] = $course['code'];
    }
    $yearLevels = [1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year'];

    $rowData = array_map(function ($student) use ($courseMap) {
      return [
        'studentID' => $student->student_id,
        'name' => $student->name,
        'gender' => $student->gender,
        'birthdate' => (new DateTime($student->birthdate))->format('d M Y'),
        'course' => $courseMap[$student->course_id] ?? 'Unknown',
        'yearLevel' => $yearLevels[$student->year_level] ?? $student->year_level,
      ];
    }, $students);

    return $rowData;
  }

  public static function deactivateStudent(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $id = $_GET['id'];
      unset($_GET['id']);

      self::setStudentConnection();

      (array) $data = array('status' => 'inactive');

      $student = new Student(Student::findByStudentId($id));
      $student->update($data);
      $student->save();

      header('Location: /group1/students');
    } else {
      echo 'Invalid request.';
    }
  }
}
