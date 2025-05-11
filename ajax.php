<?php
ob_start();
require_once 'controllers/StudentController.php';
$rowData = StudentController::fetchAll();
header('Content-Type: application/json');
echo json_encode($rowData);
ob_end_flush();
?>
