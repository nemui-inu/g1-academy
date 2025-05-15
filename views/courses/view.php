<?php
require_once 'controllers/CourseController.php';
require_once 'models/Course.php';

$course = Course::find($_GET['id']);

$allCourses = CourseController::getCourses();

$enrolled = 0;

foreach ($allCourses as $eachCourse) {
  if ($eachCourse['id'] == $course->course_id) {
    $enrolled = $eachCourse['enrolled'];
  }
}

?>

<div class="d-flex flex-column gap-3">
  <!-- (~) Page Divider -->
  <div class="d-flex flex-row gap-3">
    <!-- (~) Profile Section -->
    <div class="d-flex flex-column gap-3">
      <!-- (~) Profile Title -->
      <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Course Information</p>
      <!-- (~) Profile Card -->
      <div class="d-flex flex-column gap-4 bg-white shadow-sm rounded-3 p-3">
        <!-- (~) Pseudo Logo -->
        <div class="bg-navy rounded-2 d-flex align-items-center justify-content-center" style="width: 240px; height: 220px;">
          <p class="mb-0 fw-bold text-white text-center roboto-mono-bold m-0 p-0" style="font-size: 72px;"><?= $course->code ?></p>
        </div>
        <div class="d-flex flex-column gap-1">
          <p class="mb-0 lh-1 fw-bold text-navy" style="font-size: 18px; width: 240px;"><?= $course->name ?></p>
        </div>
        <div class="d-flex flex-row justify-content-start">
          <p class="mb-0 lh-1 text-navy opacity-75"><?= $enrolled ?> Enrolled</p>
        </div>
        <div class="d-flex flex-column gap-2 mt-3 w-100">
          <a href="/group1/courses-delete?id=<?= $course->course_id ?>" class="btn btn-sm btn-outline-red">Delete</a>
          <a href="/group1/courses-edit?id=<?= $course->course_id ?>" class="btn btn-sm btn-navy">Edit</a>
        </div>
      </div>
    </div>
    <!-- (~) Enrollment Table Section -->
    <div class="d-flex flex-column gap-3 w-100">
      <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Students Enrolled</p>
      <div class="container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
        <!-- (~) Table Utilities -->
        <div class="d-flex flex-row align-items-center justify-content-between mb-3">
          <!-- (~) Search Bar -->
          <input type="text" id="searchCourses" class="form-control w-25" style="font-size: 14px;" placeholder="Search students ..." oninput="searchCoursesTable()">
          <!-- (~) Buttons -->
          <div class="d-flex flex-row gap-2 align-items-center justify-content-center">
            <button class="btn btn-sm btn-gray px-3">
              <i class="bi bi-file-earmark-pdf me-2"></i>
              <span>Export</span>
            </button>
            <a href="courses-create" class="btn btn-sm btn-success px-3">
              <i class="bi bi-plus-square me-2"></i>
              <span>Enroll</span>
            </a>
          </div>
        </div>
        <!-- (~) Table -->
         <?php $_SESSION['enrolled_table'] = $course->code; ?>
        <div id="studentEnrolled" class=""></div>
      </div>
    </div>
  </div>
</div>
