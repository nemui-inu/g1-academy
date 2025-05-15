<?php declare(strict_types=1);

require_once 'router/Router.php';
require_once 'ajax/Ajax.php';
require_once 'controllers/LoginController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/StudentController.php';
require_once 'controllers/CourseController.php';
require_once 'controllers/InstructorController.php';

require_once 'controllers/ArchiveController.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$folder = '/group1';
$path = str_replace($folder, '', $path);

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

Router::add('/', fn() => LoginController::index());
Router::add('/login', function () {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    LoginController::login();
  } else {
    LoginController::index();
  }
});
Router::add('/logout', fn() => LoginController::logout());

Router::add('/dashboard', fn() => DashboardController::index());

// (~) Student Page Routes
Router::add('/students', fn() => StudentController::index());

Router::add('/students-create', fn() => StudentController::create());
Router::add('/students-addstudent', fn() => StudentController::add());

Router::add('/students-edit', fn() => StudentController::edit());
Router::add('/students-editstudent', fn() => StudentController::editStudent());

Router::add('/students-view', fn() => StudentController::view());

Router::add('/students-deactivatestudent', fn() => StudentController::deactivateStudent());

// (~) Course Page Routes
Router::add('/courses', fn() => CourseController::index());

Router::add('/courses-create', fn() => CourseController::create());
Router::add('/courses-addcourse', fn() => CourseController::add());

Router::add('/courses-edit', fn() => CourseController::edit());
Router::add('/courses-editcourse', fn() => CourseController::updateStudent());

Router::add('/courses-delete', fn() => CourseController::delete());

Router::add('/courses-view', fn() => CourseController::view());

// (~) Instructor Page Routes
Router::add('/instructors', fn() => InstructorController::index());

// (~) Ajax Routes
Router::add('/active_students', fn() => Ajax::activeStudents());
Router::add('/inactive_students', fn() => Ajax::inactiveStudents());
Router::add('/courses_offered', fn() => Ajax::coursesOffered());
Router::add('/enrolled_students', fn() => Ajax::enrolledStudents());

Router::add('/archive', fn() => ArchiveController::index());
Router::add('/archive_restore_student', fn() => ArchiveController::restoreStudent());

Router::dispatch($path);
