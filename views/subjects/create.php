<?php
require_once 'controllers/CourseController.php';
require_once 'controllers/InstructorController.php';

// (~) Identify ID
$subjects = SubjectController::getSubjects() ?? [];
if ($subjects != null) {
  foreach ($subjects as $subject) {
    $id = $subject['id'];
  }
} else {
  $id = 0;
}
$id += 1;

// (~) Generate Code
$code = SubjectController::generateCode();

// (~) Get Courses
$courses = CourseController::getCourses() ?? [];

// (~) Get Instructors
$instructors = InstructorController::fetchInstructors('active') ?? [];

?>

<div class="d-flex flex-column gap-3">
  <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">New Subject</p>
  <div class="text-navy container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
    <form action="/group1/subjects-add" method="POST" class="d-flex flex-column gap-3">
      <div class="d-flex flex-row gap-3">
        <div class="w-25">
          <label for="studentID" class="form-label">ID<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">automatic</span></label>
          <input type="text" id="studentID" name="subject_id" value="<?= $id ?>" class="form-control roboto-mono-regular" style="font-size: 14px;" readonly />
        </div>
        <div class="w-100">
          <label for="courseName" class="form-label">Subject Name<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="courseName" name="name" placeholder="Example: Intermediate Programming II" class="form-control" style="font-size: 14px;" required />
        </div>
        <div class="w-50">
          <label for="" class="form-label">Subject Code<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">automatic</span></label>
          <input type="text" id="subjectCode" name="code" value="<?= $code ?>"  class="form-control" style="font-size: 14px;" readonly />
        </div>
      </div>
      <div class="d-flex flex-row gap-3">
        <div class="w-25">
          <label for="studentID" class="form-label">Catalog Number<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="studentID" name="catalog_no" placeholder="Example: CAT001" class="form-control roboto-mono-regular" style="font-size: 14px;" required />
        </div>
        <div class="w-25">
          <label for="courseName" class="form-label">Course<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <select type="text" id="courseName" name="course_id" class="form-select" style="font-size: 14px;" required>
            <option value="" selected disabled>Select Course</option>
            <?php foreach ($courses as $course): ?>
              <option value="<?= $course['id'] ?>"><?= $course['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="w-25">
          <label for="courseName" class="form-label">Year Level<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <select type="text" id="courseName" name="year_level" class="form-select" style="font-size: 14px;" required>
            <option value="" selected disabled>Select Year Level</option>
            <option value="1">1st Year</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
            <option value="4">4th Year</option>
          </select>
        </div>
        <div class="w-50">
          <label for="courseName" class="form-label">Assigned Instructor<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <select type="text" id="courseName" name="instructor_id" class="form-select" style="font-size: 14px;" required>
            <option value="" selected disabled>Select Instructor</option>
            <?php foreach ($instructors as $instructor): ?>
              <option value="<?= $instructor['id'] ?>"><?= $instructor['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="d-flex flex-row gap-3">
        <div class="w-100">
          <label for="courseName" class="form-label">Day<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="studentID" name="day" placeholder="Example: T/Th" class="form-control roboto-mono-regular" style="font-size: 14px;" required />
        </div>
        <div class="w-100">
          <label for="courseName" class="form-label">Time<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="studentID" name="time" placeholder="Example: 10:00-13:00" class="form-control roboto-mono-regular" style="font-size: 14px;" required />
        </div>
        <div class="w-100">
          <label for="courseName" class="form-label">Room<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="studentID" name="room" placeholder="Example: ITLEC201" class="form-control roboto-mono-regular" style="font-size: 14px;" required />
        </div>
        <div class="w-100">
          <label for="courseName" class="form-label">Semester<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <select type="text" id="courseName" name="semester" class="form-select" style="font-size: 14px;" required>
            <option value="" selected disabled>Select Semester</option>
            <option value="1">1st Semester</option>
            <option value="2">2nd Semester</option>
          </select>
        </div>
      </div>
      <div class="d-flex flex-row gap-2 align-items-center justify-content-end mt-3">
        <a href="/group1/courses" class="btn btn-outline-navy btn-sm px-5">Cancel</a>
        <button type="submit" class="btn btn-navy btn-sm px-5">Submit</button>
      </div>
    </form>
  </div>
</div>
