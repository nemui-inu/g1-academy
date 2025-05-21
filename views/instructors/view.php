<?php

require_once 'controllers/InstructorController.php';

$instructor = InstructorController::findInstructor($_GET['id']);
$instructorId = $instructor['id'];
$instructorName = $instructor['name'];
$instructorEmail = $instructor['email'];
$instructorRole = $instructor['role'];
$instructorStatus = $instructor['status'];

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
        <img src="public/img/instructor.jpg" class="rounded-1" alt="" style="width: 240px; ">
        <div>
          <p class="mb-0 text-navy fw-bold" style="font-size: 18px;"><?= $instructorName ?></p>
          <div class="d-flex flex-row gap-1">
            <p class="mb-0 text-navy opacity-75">
              <?= $instructorRole ?>
            </p>
            <i class="bi bi-dot opacity-50"></i>
            <p class="mb-0 text-green opacity-75">
              <?= $instructorStatus ?>
            </p>
          </div>
        </div>
        <div class="d-flex flex-column gap-1">
          <p class="mb-0 text-navy opacity-75">
            <i class="bi bi-card-list me-1"></i>
            ID: <?= $instructorId ?>
          </p>
          <div class="d-flex flex-row justify-content-between align-items-center">
            <p class="mb-0 text-navy opacity-75">
              <i class="bi bi-envelope me-1"></i>
              <span><?= $instructorEmail ?></span>
            </p>
          </div>
        </div>
        <div class=" d-flex flex-column gap-2 w-100">
          <a href="/group1/instructors-deactivate?id=<?= $instructorId ?>" class="btn btn-sm btn-outline-red">Deactivate</a>
          <a href="/group1/instructor-edit?id=<?= $instructorId ?>" class="btn btn-sm btn-navy">Edit</a>
        </div>
      </div>
    </div>
    <!-- (~) Enrollment Table Section -->
    <div class="d-flex flex-column gap-3 w-100">
      <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Subjects</p>
      <div class="d-flex flex-column gap-3 bg-white shadow-sm rounded-3 p-5 align-items-center">
        <p class="mb-0 text-navy">No subjects assigned yet.</p>
      </div>
    </div>
  </div>
</div>
