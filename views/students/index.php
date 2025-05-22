<?php
  if (isset($_SESSION['user']) && isset($_SESSION['user']['role'])) {
      $user_role = $_SESSION['user']['role'];

      if ($user_role === 'instructor' && strpos($_SERVER['REQUEST_URI'], '/students') !== false) {
          echo 'Access denied. Instructors are not authorized to view this section.';
          exit();
      }

      $database = new Database();
      $conn = $database->getConnection();
      ?>

      <div class="d-flex flex-column gap-5">
          <!-- Active Students Table -->
          <div class="d-flex flex-column gap-3">
              <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Active Students</p>
              <div class="d-flex flex-row gap-3">
                  <div class="container-fluid p-0 m-0 p-3 bg-white rounded-3 d-flex flex-column gap-0 justify-content-center shadow-sm">
                      <!-- Table Utilities -->
                      <div class="d-flex flex-row align-items-center justify-content-between mb-3">
                          <!-- Search Bar -->
                          <input type="text" id="searchActiveStudentBar" class="form-control w-25" style="font-size: 14px;" placeholder="Search students ..." oninput="searchActiveStudentTable()">
                          <!-- Buttons -->
                          <div class="d-flex flex-row gap-2 align-items-center justify-content-center">
                              <button class="btn btn-sm btn-gray px-3" onclick="exportToPDF()">
                                  <i class="bi bi-file-earmark-pdf me-2"></i>
                                  <span>Export</span>
                              </button>
                              <a href="students-create" class="btn btn-sm btn-success px-3">
                                  <i class="bi bi-plus-square me-2"></i>
                                  <span>Create</span>
                              </a>
                          </div>
                      </div>

                      <!-- Table Content -->
                      <div>
                          <div id="active-students-message" class="text-danger mt-2"></div>
                          <div id="activeStudents" class="" style="overflow-x: auto;"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- Script -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-grid.css" />
      <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>
      <script src="public/js/activeStudents.js"></script>

      <?php
  } else {
      header('Location: auth/login.php');
      exit();
  }
?>
