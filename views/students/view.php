<?php

require_once 'controllers/CourseController.php';
require_once 'controllers/StudentController.php';

$view_user = $_SESSION['view_user'];
unset($_SESSION['view_user']);

$studentName = $view_user['name'];
$name = explode(' ', $view_user['name']);

$firstName = $name[0];
$lastName = $name[count($name) - 1];

$id = $view_user['id'];
$studentId = $view_user['student_id'];

$gender = $view_user['gender'];

$birthdateObject = new DateTime($view_user['birthdate']);
$birthdate = $birthdateObject->format('j F Y');

$course = $view_user['course_id'];
$course = CourseController::identifyCourse($course);

$yearLevel = $view_user['year_level'];
$yearLevel = StudentController::getYearLevel($yearLevel);

$status = $view_user['status'];

?>

<div class="d-flex flex-column gap-3">
  <!-- (~) Page Divider -->
  <div class="d-flex flex-row gap-3">
    <!-- (~) Profile Section -->
    <div class="d-flex flex-column gap-3">
      <!-- (~) Profile Title -->
      <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Basic Information</p>
      <!-- (~) Profile Card -->
      <div class="d-flex flex-column gap-4 bg-white shadow-sm rounded-3 p-3">
        <img src="public/img/<?= (strtolower($gender) == 'male') ? 'male' : 'female' ?>.jpg" class="rounded-2" alt="" style="width: 240px; ">
        <div>
          <p class="mb-0 text-navy fw-bold" style="font-size: 18px;"><?= $studentName ?></p>
          <p class="mb-0 text-navy opacity-75">
            <?= $studentId ?>
            <i class="bi bi-card-list ms-1"></i>
          </p>
        </div>
        <div class="d-flex flex-column gap-1">
          <div class="d-flex flex-row justify-content-between align-items-center">
            <p class="mb-0 text-navy opacity-75">
              <i class="bi bi-calendar4-week me-1"></i>
              <span><?= $birthdate ?></span>
            </p>
            <p class="mb-0 text-navy opacity-75">
              <span><?= $gender ?></span>
              <i class="bi bi-gender-<?= strtolower($gender) ?>"></i>
            </p>
          </div>
          <div class="d-flex flex-row justify-content-between align-items-center">
            <p class="mb-0 text-navy opacity-75">
              <i class="bi bi-collection-fill me-1"></i>
              <span><?= $course ?></span>
            </p>
            <p class="mb-0 text-navy opacity-75">
              <i class="bi bi-bar-chart-steps me-1"></i>
              <span><?= $yearLevel ?> </span>
            </p>
          </div>
        </div>
        <div class=" d-flex flex-column gap-2 w-100">
          <a href="/group1/students-deactivatestudent?id=<?= $studentId ?>" class="btn btn-sm btn-outline-red">Deactivate</a>
          <a href="/group1/students-edit?id=<?= $studentId ?>" class="btn btn-sm btn-navy">Edit</a>
        </div>
      </div>
    </div>
    <!-- (~) Enrollment Table Section -->
    <div class="d-flex flex-column gap-3 w-100">
      <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Subjects Enrolled</p>
      <div class="d-flex flex-column gap-3 bg-white shadow-sm rounded-3 p-5 align-items-center">
        <p class="mb-0 text-navy">No subjects enrolled yet.</p>
      </div>
    </div>
  </div>
</div>
