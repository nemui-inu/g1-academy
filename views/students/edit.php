<?php

$edit_user = $_SESSION['edit_user'];
unset($_SESSION['edit_user']);

$name = explode(' ', $edit_user['name']);

$firstName = $name[0];
$lastName = $name[count($name) - 1];

$id = $edit_user['id'];
$studentId = $edit_user['student_id'];

$gender = $edit_user['gender'];
$birthdate = $edit_user['birthdate'];

$yearLevel = $edit_user['year_level'];
$course = $edit_user['course_id'];
$status = $edit_user['status'];

$coursesTable = CourseController::getCourses();

?>

<div class="d-flex flex-column gap-3">
  <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Edit Student</p>
  <div class="text-navy container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
    <form action="/group1/students-editstudent" method="POST" class="d-flex flex-column gap-3">
      <div class="row">
        <div class="col-3">
          <label for="studentFirstName" class="form-label">First Name</label>
          <input type="text" id="studentFirstName" name="firstName" class="form-control" style="font-size: 14px;" value="<?= $firstName; ?>" />
        </div>
        <div class="col-3">
          <label for="studentLastName" class="form-label">Last Name</label>
          <input type="text" id="studentLastName" name="lastName" class="form-control" style="font-size: 14px;" value="<?= $lastName ?>" />
        </div>
        <div class="col-3">
          <label for="studentID" class="form-label">ID<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">read-only</span></label>
          <input type="text" id="studentID" name="id" value="<?= $id ?>" class="form-control roboto-mono-regular" style="font-size: 14px;" readonly />
        </div>
        <div class="col-3">
          <label for="studentStudentID" class="form-label">Student ID<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">read-only</span></label>
          <input type="text" id="studentStudentID" name="studentID" value="<?= $studentId ?>" class="form-control roboto-mono-regular" style="font-size: 14px;" readonly />
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          <label for="studentGender" class="form-label">Gender</label>
          <select name="gender" id="studentGender" class="form-select" style="font-size: 14px;">
            <option>-- Select --</option>
            <option value="Male" <?= (strtolower($gender) == 'male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (strtolower($gender) == 'female') ? 'selected' : '' ?>>Female</option>
          </select>
        </div>
        <div class="col-3">
          <label for="studentBirthdate" class="form-label">Birthdate</label>
          <input type="date" id="studentBirthdate" name="birthdate" class="form-control" style="font-size: 14px;" value="<?= $birthdate; ?>"/>
        </div>
        <div class="col-3">
          <label for="studentYearLevel" class="form-label">Year Level</label>
          <select name="yearLevel" id="studentYearLevel" class="form-select" style="font-size: 14px;" required>
            <option selected>-- Select --</option>
            <option value="1" <?= ($yearLevel == '1') ? 'selected' : '' ?>>1st Year</option>
            <option value="2" <?= ($yearLevel == '2') ? 'selected' : '' ?>>2nd Year</option>
            <option value="3" <?= ($yearLevel == '3') ? 'selected' : '' ?>>3rd Year</option>
            <option value="4" <?= ($yearLevel == '4') ? 'selected' : '' ?>>4th Year</option>
          </select>
        </div>
        <div class="col-3">
          <label for="studentCourse" class="form-label">Course</label>
          <select name="course" id="studentCourse" class="form-select" style="font-size: 14px;">
            <option>-- Select --</option>
            <?php foreach ($coursesTable as $studentCourse): ?>
            <option value="<?= $studentCourse['id'] ?>" <?= ($course == $studentCourse['id']) ? 'selected' : '' ?>>
            <?= $studentCourse['code'] ?>
            </option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          <label for="studentStatus" class="form-label">Status</label>
          <select name="status" id="studentStatus" class="form-select" style="font-size: 14px;">
            <option selected>-- Select --</option>
            <option value="Active" <?= (strtolower($status) == 'active') ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= (strtolower($status) == 'inactive') ? 'selected' : '' ?>>Inactive</option>
          </select>
        </div>
      </div>
      <div class="d-flex flex-row gap-2 align-items-center justify-content-end mt-3">
        <a href="/group1/students" class="btn btn-outline-navy btn-sm px-5">Cancel</a>
        <button type="submit" class="btn btn-navy btn-sm px-5">Submit</button>
      </div>
    </form>
  </div>
</div>
