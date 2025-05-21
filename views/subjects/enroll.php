<div class="d-flex flex-column gap-5">
  <!-- (~) Active Students Table -->
  <div class="d-flex flex-column gap-3">
    <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Enroll Students</p>
    <div class="d-flex flex-row gap-3">
      <div class="container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
        <!-- (~) Table Utilities -->
        <div class="d-flex flex-row align-items-center justify-content-center mb-3 gap-3">
          <!-- (~) Search Bar -->
          <div class="d-flex flex-row align-items-center gap-2 w-25">
            <input type="text" id="enrollmentSearch" class="form-control w-100" style="font-size: 14px;" placeholder="Search students ..." oninput="enrollSearch()">
          </div>
        </div>
        <!-- (~) Table -->
        <div id="studentsEnroll" class="" ></div>
        <!-- (~) GoBack Button -->
        <div class="d-flex flex-row align-items-center justify-content-end mt-3 gap-3">
          <a href="subjects-view?id=<?= $_GET['id'] ?>" class="btn btn-sm btn-outline-gray px-3">Go Back</a>
        </div>
      </div>
    </div>
  </div>
</div>
