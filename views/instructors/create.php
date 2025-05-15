<?php
$results = InstructorController::fetchInstructors();

foreach ($results as $result) {
  $id = $result['id'];
}

$id += 1;

?>

<div class="d-flex flex-column gap-3">
  <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">New Instructor</p>
  <div class="text-navy container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
    <form action="/group1/instructors-addinstructor" method="POST" class="d-flex flex-column gap-3">
      <div class="d-flex flex-row gap-3">
        <div class="w-100">
          <label for="instructorFirstName" class="form-label">First Name<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="instructorFirstName" name="first_name" placeholder="Example: John" class="form-control" style="font-size: 14px;" required />
        </div>
        <div class="w-100">
          <label for="instructorLastName" class="form-label">Last Name<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="instructorLastName" name="last_name" placeholder="Example: Doe" class="form-control" style="font-size: 14px;" required />
        </div>
        <div class="w-25">
          <label for="instructorId" class="form-label">User ID<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">automatic</span></label>
          <input type="text" id="instructorId" name="user_id" value="<?= $id ?>" class="form-control roboto-mono-regular" style="font-size: 14px;" readonly />
        </div>
      </div>
      <div class="d-flex flex-row gap-3">
        <div class="w-50">
          <label for="instructorPassword" class="form-label">Password<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="instructorEmail" name="password" placeholder="Example: #xi<3$BbY$x#" class="form-control" style="font-size: 14px;" required />
        </div>
        <div class="w-50">
          <label for="instructorEmail" class="form-label">Email<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">required</span></label>
          <input type="text" id="instructorEmail" name="email" placeholder="Example: john_doe@email.com" class="form-control" style="font-size: 14px;" required />
        </div>
        <div class="w-25">
          <label for="instructorStatus" class="form-label">Status<span class="text-black p-1 rounded-3 fst-italic fw-semibold ms-2 opacity-25">automatic</span></label>
          <input type="text" id="instructorStatus" name="status" value="Active" class="form-control" style="font-size: 14px;" readonly />
        </div>
      </div>
      <input type="hidden" name="role" value="Instructor">
      <div class="d-flex flex-row gap-2 align-items-center justify-content-end mt-3">
        <a href="/group1/courses" class="btn btn-outline-navy btn-sm px-5">Cancel</a>
        <button type="submit" class="btn btn-navy btn-sm px-5">Submit</button>
      </div>
    </form>
  </div>
</div>
