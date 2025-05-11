<!-- (~) Sidebar Container -->
<div class="bg-white shadow-sm rounded-3 d-flex flex-column justify-content-between pt-4 pb-2" style="height: calc(100% - 32px); width: 235px; position: fixed;">
  <!-- (~) Top Part / Logo & Links -->
  <div class="d-flex flex-column">
    <!-- (~) Logo Face -->
    <div class="d-flex flex-column justify-content-center align-items-center">
      <img src="public/svg/logo-2.svg" alt="Logo" class="img-fluid" style="width: auto; height: 42px;">
    </div>
    <!-- (~) Nav Links -->
    <div class="d-flex flex-column gap-3 align-items-start fw-semibold p-3" style="margin-top: 25px;">
      <a href="/group1/dashboard" class="text-decoration-none <?= ($_SESSION['page'] == 'dashboard') ? 'bg-navy text-white' : 'bg-white text-navy' ?> pe-2 ps-4 py-2 w-100 rounded-3">
        <i class="bi bi-bar-chart-fill me-2"></i>
        Dashboard
      </a>
      <a href="/group1/dashboard" class="text-decoration-none <?= ($_SESSION['page'] == 'admins') ? 'bg-navy text-white' : 'bg-white text-navy' ?> pe-2 ps-4 py-2 w-100 rounded-3">
        <i class="bi bi-diagram-3-fill me-2"></i>
        Admins
      </a>
      <a href="/group1/dashboard" class="text-decoration-none <?= ($_SESSION['page'] == 'instructors') ? 'bg-navy text-white' : 'bg-white text-navy' ?> pe-2 ps-4 py-2 w-100 rounded-3">
        <i class="bi bi-person-workspace me-2"></i>
        Instructors
      </a>
      <a href="/group1/students" class="text-decoration-none <?= ($_SESSION['page'] == 'students') ? 'bg-navy text-white' : 'bg-white text-navy' ?> pe-2 ps-4 py-2 w-100 rounded-3">
        <i class="bi bi-mortarboard-fill me-2"></i>
        Students
      </a>
      <a href="/group1/dashboard" class="text-decoration-none <?= ($_SESSION['page'] == 'courses') ? 'bg-navy text-white' : 'bg-white text-navy' ?> pe-2 ps-4 py-2 w-100 rounded-3">
        <i class="bi bi-collection-fill me-2"></i>
        Courses
      </a>
      <a href="/group1/dashboard" class="text-decoration-none <?= ($_SESSION['page'] == 'subjects') ? 'bg-navy text-white' : 'bg-white text-navy' ?> pe-2 ps-4 py-2 w-100 rounded-3">
        <i class="bi bi-book-half me-2"></i>
        Subjects
      </a>
    </div>
  </div>
  <!-- (~) Bottom Part / Logout -->
  <div class="d-flex flex-column fw-semibold p-3">
    <a href="/group1/logout" class="text-decoration-none bg-whiet btn btn-outline-red pe-2 ps-4 py-2 w-100 text-start border-0 fw-semibold rounded-3" style="font-size: 14px;">
      <i class="bi bi-box-arrow-left me-2"></i>
      Logout
    </a>
  </div>
</div>