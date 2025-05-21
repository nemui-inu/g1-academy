<?php declare(strict_types=1);

require_once 'controllers/StudentController.php';
require_once 'controllers/CourseController.php';
require_once 'controllers/InstructorController.php';
require_once 'controllers/DashboardController.php';

class Ajax
{
  public static function activeStudents(): void
  {
    ob_start();
    $rowData = StudentController::fetchStudents('active');
    header('Content-Type: application/json');
    echo json_encode($rowData);
    ob_end_flush();
  }

  public static function inactiveStudents(): void
  {
    ob_start();
    $rowData = StudentController::fetchStudents('inactive');
    header('Content-Type: application/json');
    echo json_encode($rowData);
    ob_end_flush();
  }

  public static function coursesOffered(): void
  {
    ob_start();
    $rowData = CourseController::getCourses();
    header('Content-Type: application/json');
    echo json_encode($rowData);
    ob_end_flush();
  }

  public static function enrolledStudents(): void
  {
    ob_start();
    $rowData = StudentController::fetchByCourseId();
    header('Content-Type: application/json');
    echo json_encode($rowData);
    ob_end_flush();
  }

  public static function activeInstructors(): void
  {
    ob_start();
    $rowData = InstructorController::fetchInstructors('active');
    header('Content-Type: application/json');
    echo json_encode($rowData);
    ob_end_flush();
  }

  public static function inactiveInstructors(): void
  {
    ob_start();
    $rowData = InstructorController::fetchInstructors('inactive');
    header('Content-Type: application/json');
    echo json_encode($rowData);
    ob_end_flush();
  }

  public static function activeAdmins(): void
  {
    ob_start();
    $rowData = AdminController::fetchAdmins('active');
    header('Content-Type: application/json');
    echo json_encode($rowData);
    ob_end_flush();
  }

  public static function inactiveAdmins(): void
  {
    ob_start();
    $rowData = AdminController::fetchAdmins('inactive');
    header('Content-Type: application/json');
    echo json_encode($rowData);
    ob_end_flush();
  }

  public static function pendingGradingDetails(): void
  {
    ob_start();
    $instructor_id = $_SESSION['user']['user_id'];
    $rowData = DashboardController::getPendingGradingDetails((int) $instructor_id);
    header('Content-Type: application/json');
    echo json_encode($rowData);
    ob_end_flush();
  }
}
