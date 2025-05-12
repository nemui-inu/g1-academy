<?php declare(strict_types=1);

require_once 'controllers/StudentController.php';

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
}
