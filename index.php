<?php declare(strict_types=1);

require_once 'router/Router.php';
require_once 'ajax/Ajax.php';
require_once 'controllers/LoginController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/StudentController.php';
require_once 'controllers/CourseController.php';
require_once 'controllers/InstructorController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/SubjectController.php';

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

Router::add('/instructors-create', fn() => InstructorController::create());
Router::add('/instructors-addinstructor', fn() => InstructorController::add());

Router::add('/instructor-view', fn() => InstructorController::view());

Router::add('/instructor-edit', fn() => InstructorController::edit());
Router::add('/instructors-update', fn() => InstructorController::update());

Router::add('/instructor-deactivate', fn() => InstructorController::deactivate());

// (~) Admin Page Routes
Router::add('/admins', fn() => AdminController::index());

Router::add('/admins-create', fn() => AdminController::create());

Router::add('/admins-view', fn() => AdminController::view());

Router::add('/admins-edit', fn() => AdminController::edit());
Router::add('/admins-update', fn() => AdminController::update());

Router::add('/admins-deactivate', fn() => AdminController::deactivate());

// (~) Subject Page Routes
Router::add('/subjects', fn() => SubjectController::index());

Router::add('/subjects-create', fn() => SubjectController::create());
Router::add('/subjects-add', fn() => SubjectController::add());

Router::add('/subjects-view', fn() => SubjectController::view());
Router::add('/subjects-enroll', fn() => SubjectController::enroll());

// (~) Ajax Routes
Router::add('/active_students', fn() => Ajax::activeStudents());
Router::add('/inactive_students', fn() => Ajax::inactiveStudents());

Router::add('/courses_offered', fn() => Ajax::coursesOffered());
Router::add('/enrolled_students', fn() => Ajax::enrolledStudents());

Router::add('/instructors_table', fn() => Ajax::activeInstructors());
Router::add('/inactive_instructors', fn() => Ajax::inactiveInstructors());

Router::add('/active_admins', fn() => Ajax::activeAdmins());
Router::add('/inactive_admins', fn() => Ajax::inactiveAdmins());

Router::add('/subjects_offered', fn() => Ajax::subjectsOffered());
Router::add('/enrollment_list', fn() => Ajax::enrollmentList());

// (~) Archive Page Routes
Router::add('/archive', fn() => ArchiveController::index());
Router::add('/archive_restore_student', fn() => ArchiveController::restoreStudent());
Router::add('/archive_restore_instructor', fn() => InstructorController::restoreInstructor());
Router::add('/archive_restore_admin', fn() => AdminController::restoreAdmin());

Router::add('/pending_grading_details', fn() => Ajax::pendingGradingDetails());

Router::dispatch($path);
