<?php declare(strict_types=1);

require_once 'controllers/StudentController.php';
require_once 'controllers/CourseController.php';

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
}
