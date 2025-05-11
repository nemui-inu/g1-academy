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
    require_once 'layout/footer.php';
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

  public static function add(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      self::setStudentConnection();

      $result = Student::all();
      $lastId = (int) $result[count($result) - 1]->id;

      $studentId = 'STU';

      if (++$lastId < 10) {
        $studentId .= '000';
      } else if (++$lastId > 9 && ++$lastId < 100) {
      } else if (++$lastId > 99 && ++$lastId < 1000) {
        $studentId .= '00';
      }

      $studentId .= (string) ++$lastId;

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

  public static function fetchAll(): array
  {
    self::setStudentConnection();

    $results = Student::all();
    $students = [];

    foreach ($results as $result) {
      if ($result->status == 'inactive') {
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
}
