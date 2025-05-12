<?php
$ids = self::getLastId();

$id = $ids['id'];
$studentId = $ids['student_id'];
?>

<div class="d-flex flex-column gap-3">
  <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">New Student</p>
  <div class="text-navy container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
    <form action="/group1/students-addstudent" method="POST" class="d-flex flex-column gap-3">
      <div class="row">
        <div class="col-3">
          <label for="studentFirstName" class="form-label">First Name<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="studentFirstName" name="firstName" placeholder="Example: John" class="form-control" style="font-size: 14px;" required />
        </div>
        <div class="col-3">
          <label for="studentLastName" class="form-label">Last Name<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="studentLastName" name="lastName" placeholder="Example: Doe" class="form-control" style="font-size: 14px;" required />
        </div>
        <div class="col-3">
          <label for="studentID" class="form-label">ID<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">automatic</span></label>
          <input type="text" id="studentID" name="id" value="<?= $id ?>" class="form-control roboto-mono-regular" style="font-size: 14px;" disabled />
        </div>
        <div class="col-3">
          <label for="studentStudentID" class="form-label">Student ID<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">automatic</span></label>
          <input type="text" id="studentStudentID" name="studentID" value="<?= $studentId ?>" class="form-control roboto-mono-regular" style="font-size: 14px;" disabled />
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          <label for="studentGender" class="form-label">Gender<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <select name="gender" id="studentGender" class="form-select" style="font-size: 14px;">
            <option selected>-- Select --</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="col-3">
          <label for="studentBirthdate" class="form-label">Birthdate<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="date" id="studentBirthdate" name="birthdate" class="form-control" style="font-size: 14px;" required />
        </div>
        <div class="col-3">
          <label for="studentYearLevel" class="form-label">Year Level<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <select name="yearLevel" id="studentYearLevel" class="form-select" style="font-size: 14px;" required>
            <option selected>-- Select --</option>
            <option value="1">1st Year</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
            <option value="4">4th Year</option>
          </select>
        </div>
        <div class="col-3">
          <label for="studentCourse" class="form-label">Course<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <select name="course" id="studentCourse" class="form-select" style="font-size: 14px;">
            <option selected>-- Select --</option>
            <option value="1">BSIT</option>
            <option value="2">BSCS</option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          <label for="studentStatus" class="form-label">Status<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <select name="status" id="studentStatus" class="form-select" style="font-size: 14px;">
            <option selected>-- Select --</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
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
