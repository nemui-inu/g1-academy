<?php declare(strict_types=1);

require_once 'controllers/Controller.php';
require_once 'controllers/StudentController.php';
require_once 'controllers/CourseController.php';
require_once 'controllers/InstructorController.php';

require_once 'models/Subject.php';
require_once 'models/Course.php';
require_once 'models/Database.php';
require_once 'models/Enrollment.php';

class SubjectController extends Controller
{
  public static string $pageDir = 'views/subjects/index.php';

  public static function index(): void
  {
    $_SESSION['page'] = 'subjects';
    $_SESSION['path'] = [
      'Subjects' => '/group1/subjects',
      'Overview' => '/group1/subjects',
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once self::$pageDir;
    require_once 'layout/components/frame_foot.php';
    echo '<script src="public/js/subjectsOffered.js"></script>';
    require_once 'layout/footer.php';
  }

  public static function setSubjectConnection(): void
  {
    $db = new Database();
    $conn = $db->getConnection();

    Subject::setConnection($conn);
  }

  public static function create(): void
  {
    $_SESSION['page'] = 'subjects';
    $_SESSION['path'] = [
      'Subjects' => '/group1/subjects',
      'Create' => '/group1/subjects-create',
    ];

    require_once 'layout/header.php';
    require_once 'layout/components/frame_head.php';
    require_once 'views/subjects/create.php';
    require_once 'layout/components/frame_foot.php';
    require_once 'layout/footer.php';
  }

  public static function getSubjects(): array
  {
    self::setSubjectConnection();

    $all = Subject::all();

    if (!empty($all)) {
      $results = [];

      foreach ($all as $key) {
        $results[] = $key;
      }

      $rowData = array_map(function ($result) {
        return [
          'id' => $result->id,
          'code' => $result->code,
          'catalog_no' => $result->catalog_no,
          'name' => $result->name,
          'day' => $result->name,
          'time' => $result->time,
          'room' => $result->room,
          'course_id' => self::getCourseCode($result->course_id),
          'semester' => self::getSemester($result->semester),
          'year_level' => self::getYearLevel($result->year_level),
          'instructor_id' => self::getInstructorName($result->instructor_id),
          'created_at' => $result->created_at,
          'updated_at' => $result->updated_at,
        ];
      }, $results);

      return $rowData;
    } else {
      return [];
    }
  }

  public static function generateCode(): string
  {
    // Generate subject code based on timestamp, 8 characters
    $timestamp = (string) time();
    $timestamp = substr($timestamp, -4);
    $code = 'GSUB' . $timestamp;
    return $code;
  }

  public static function add(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      self::setSubjectConnection();
      $data = [
        'code' => $_POST['code'],
        'catalog_no' => $_POST['catalog_no'],
        'name' => $_POST['name'],
        'day' => $_POST['day'],
        'time' => $_POST['time'],
        'room' => $_POST['room'],
        'course_id' => $_POST['course_id'],
        'semester' => $_POST['semester'],
        'year_level' => $_POST['year_level'],
        'instructor_id' => $_POST['instructor_id'],
      ];

      Subject::create($data);

      header('Location: /group1/subjects');
    } else {
      echo 'Invalid request.';
    }
  }

  public static function getCourseCode($id): string
  {
    $course = CourseController::findCourse($id);
    if ($course) {
      return $course['code'];
    } else {
      return null;
    }
  }

  public static function getYearLevel($year): string
  {
    switch ($year) {
      case 1:
        return '1st Year';
      case 2:
        return '2nd Year';
      case 3:
        return '3rd Year';
      case 4:
        return '4th Year';
      default:
        return 'Unknown Year Level';
    }
  }

  public static function getSemester($sem): string
  {
    switch ($sem) {
      case 1:
        return '1st Semester';
      case 2:
        return '2nd Semester';
      default:
        return 'Unknown Semester';
    }
  }

  public static function getInstructorName($id): string
  {
    $instructor = InstructorController::findInstructor($id);
    if ($instructor) {
      return $instructor['name'];
    } else {
      return null;
    }
  }

  public static function view(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      self::setSubjectConnection();
      $id = $_GET['id'];

      $subject = Subject::find($id);

      if ($subject) {
        $_SESSION['page'] = 'subjects';
        $_SESSION['path'] = [
          'Subjects' => '/group1/subjects',
          'View' => '/group1/subjects-view',
        ];

        require_once 'layout/header.php';
        require_once 'layout/components/frame_head.php';
        include 'views/subjects/view.php';
        require_once 'layout/components/frame_foot.php';
        echo '<script src="public/js/subjectEnrollment.js"></script>';
        require_once 'layout/footer.php';
      } else {
        echo 'Subject not found.';
      }
    } else {
      echo 'Invalid request.';
    }
  }

  public static function findSubject($id): ?array
  {
    self::setSubjectConnection();
    $subject = Subject::find($id);

    if ($subject) {
      return [
        'id' => $subject->id,
        'code' => $subject->code,
        'catalog_no' => $subject->catalog_no,
        'name' => $subject->name,
        'day' => $subject->day,
        'time' => $subject->time,
        'room' => $subject->room,
        'course_id' => $subject->course_id,
        'semester' => $subject->semester,
        'year_level' => $subject->year_level,
        'instructor_id' => $subject->instructor_id,
      ];
    } else {
      return null;
    }
  }

  public static function enroll(): void
  {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $id = $_GET['id'];
      self::setSubjectConnection();
      $subject = Subject::find($id);

      $_SESSION['page'] = 'subjects';
      $_SESSION['path'] = [
        'Subjects' => '/group1/subjects',
        'View' => '/group1/subjects-view?id=' . $id,
        'Enroll' => '/group1/subjects-enroll?id=' . $id,
      ];

      require_once 'layout/header.php';
      require_once 'layout/components/frame_head.php';
      require_once 'views/subjects/enroll.php';
      require_once 'layout/components/frame_foot.php';
      echo '<script src="public/js/enrollmentList.js"></script>';
      require_once 'layout/footer.php';
    }
  }

  public static function enrollmentList(): array
  {
    self::setSubjectConnection();
    StudentController::setStudentConnection();

    $students = StudentController::fetchStudents('active');
    $enrollments = Enrollment::all();

    foreach ($students as $key => $student) {
      if ($enrollments) {
        foreach ($enrollments as $enrollment) {
          if ($student['id'] == $enrollment->student_id) {
            unset($students[$key]);
            break;
          }
        }
      }
    }
    return $students;
  }
}
