<?php
$courses = CourseController::getCourses();

foreach ($courses as $course) {
  $id = $course['id'];
}

$id += 1;

?>

<div class="d-flex flex-column gap-3">
  <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">New Course</p>
  <div class="text-navy container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
    <form action="/group1/courses-addcourse" method="POST" class="d-flex flex-column gap-3">
      <div class="d-flex flex-row gap-3">
        <div class="w-25">
          <label for="studentID" class="form-label">ID<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">automatic</span></label>
          <input type="text" id="studentID" name="course_id" value="<?= $id ?>" class="form-control roboto-mono-regular" style="font-size: 14px;" readonly />
        </div>
        <div class="w-100">
          <label for="courseName" class="form-label">Course Name<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="courseName" name="name" placeholder="Example: Bachelor of Science in Information Technology" class="form-control" style="font-size: 14px;" required />
        </div>
        <div class="w-50">
          <label for="courseName" class="form-label">Course Code<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="courseName" name="code" placeholder="Example: BSIT" class="form-control" style="font-size: 14px;" required />
        </div>
      </div>
      <div class="d-flex flex-row gap-2 align-items-center justify-content-end mt-3">
        <a href="/group1/courses" class="btn btn-outline-navy btn-sm px-5">Cancel</a>
        <button type="submit" class="btn btn-navy btn-sm px-5">Submit</button>
      </div>
    </form>
  </div>
</div>
