<div class="d-flex flex-column gap-5">
  <!-- (~) Inactive Students Table -->
  <div class="d-flex flex-column gap-3">
    <div class="d-flex flex-column gap-5">
      <div class="d-flex flex-column gap-3">
        <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Inactive Admins</p>
        <!-- (~) Inactive Instructors Table -->
        <div class="container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
          <!-- (~) Table Utilities -->
          <div class="d-flex flex-row align-items-center justify-content-between mb-3">
            <!-- (~) Search Bar -->
            <input type="text" id="inactiveAdminSearch" class="form-control w-25" style="font-size: 14px;" placeholder="Search instructors ..." oninput="inactiveAdminSearch()">
            <!-- (~) Buttons -->
            <div class="d-flex flex-row gap-2 align-items-center justify-content-center">
              <button class="btn btn-sm btn-gray px-3">
                <i class="bi bi-file-earmark-pdf me-2"></i>
                <span>Export</span>
              </button>
            </div>
          </div>
          <!-- (~) Table -->
          <div id="inactiveAdmins" class="" ></div>
        </div>
      </div>
      <div class="d-flex flex-column gap-3">
        <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Inactive Instructors</p>
        <!-- (~) Inactive Instructors Table -->
        <div class="container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
          <!-- (~) Table Utilities -->
          <div class="d-flex flex-row align-items-center justify-content-between mb-3">
            <!-- (~) Search Bar -->
            <input type="text" id="inactiveInstructorSearch" class="form-control w-25" style="font-size: 14px;" placeholder="Search instructors ..." oninput="instructorInactiveSearch()">
            <!-- (~) Buttons -->
            <div class="d-flex flex-row gap-2 align-items-center justify-content-center">
              <button class="btn btn-sm btn-gray px-3">
                <i class="bi bi-file-earmark-pdf me-2"></i>
                <span>Export</span>
              </button>
            </div>
          </div>
          <!-- (~) Table -->
          <div id="inactiveInstructors" class="" ></div>
        </div>
      </div>
      <div class="d-flex flex-column gap-3">
        <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Inactive Students</p>
        <!-- (~) Inactive Students Table -->
        <div class="container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
          <!-- (~) Table Utilities -->
          <div class="d-flex flex-row align-items-center justify-content-between mb-3">
            <!-- (~) Search Bar -->
            <input type="text" id="inactiveStudentSearch" class="form-control w-25" style="font-size: 14px;" placeholder="Search students ..." oninput="onSearchBarInput()">
            <!-- (~) Buttons -->
            <div class="d-flex flex-row gap-2 align-items-center justify-content-center">
              <button class="btn btn-sm btn-gray px-3">
                <i class="bi bi-file-earmark-pdf me-2"></i>
                <span>Export</span>
              </button>
            </div>
          </div>
          <!-- (~) Table -->
          <div id="inactiveStudents" class="" ></div>
        </div>
      </div>
    </div>
  </div>
</div>