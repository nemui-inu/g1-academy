<?php declare(strict_types=1);

require_once 'controllers/DashboardController.php';

$totals = [
  'Admins' => DashboardController::getUserCount('admin'),
  'Instructors' => DashboardController::getUserCount('instructor'),
  'Students' => DashboardController::getStudentCount(),
  'Courses' => 0,
  'Subjects' => 0
];

$icons = [
  '<i class="bi bi-diagram-3-fill opacity-75"></i>',
  '<i class="bi bi-person-workspace opacity-75"></i>',
  '<i class="bi bi-mortarboard-fill opacity-75"></i>',
  '<i class="bi bi-collection-fill opacity-75"></i>',
  '<i class="bi bi-book-half opacity-75"></i>',
];

?>

<!-- (~) Super & Admin Dashboard -->

<!-- (~) Totals -->
<div class="d-flex flex-column gap-3">
  <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Totals</p>
  <div class="d-flex flex-row gap-3">
    <?php $i = 0;
    foreach ($totals as $key => $trigger): ?>
    <div class="container-fluid m-0 px-4 pt-3 pb-4 bg-white rounded-3 d-flex flex-row gap-0 justify-content-between align-items-center shadow-sm">
        <p class="mb-0 roboto-mono-bold text-navy lh-1" style="font-size: 34px;"><?= $trigger ?></p>
        <div class="d-flex flex-row align-items-center justify-content-start gap-2">
          <p class="mb-0 roboto-regular text-navy opacity-75 fw-semibold"><?= $key; ?></p>
          <?= $icons[$i++] ?>
        </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- (~) Students & Instructors Row -->
<div class="d-flex flex-row gap-3">

  <?php
  $studentsByYear = DashboardController::getStudentByYear();

  foreach ($studentsByYear as $key => $value) {
    switch ($value['year_level']) {
      case 1:
        $studentsByYear[$key]['year_level'] = '1st Year';
        break;
      case 2:
        $studentsByYear[$key]['year_level'] = '2nd Year';
        break;
      case 3:
        $studentsByYear[$key]['year_level'] = '3rd Year';
        break;
      case 4:
        $studentsByYear[$key]['year_level'] = '4th Year';
        break;
      default:
        $studentsByYear[$key]['year_level'] = 'Unknown';
    }
  }

  ?>

  <!-- (~) Students Column -->
  <div class="d-flex flex-column gap-3 container-fluid m-0 p-0">
    <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Students</p>
    <!-- (~) Students Column Content -->
    <div class="container-fluid m-0 p-0 p-3 bg-white shadow-sm rounded-3">
      <canvas id="studentChart"></canvas>
    </div>
  </div>

  <!-- (~) Instructors Column -->
  <div class="d-flex flex-column gap-3 w-50 m-0 p-0">
    <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Instructors</p>
    <!-- (~) Instructors Content -->
    <div class="container-fluid m-0 bg-white shadow-sm p-3 rounded-3 d-flex flex-column justify-content-between h-100">
      <div class="d-flex flex-column gap-1">
        <?php for ($i = 0; $i < 6; $i++): ?>
        <div class="d-flex flex-row justify-content-between align-items-center bg-dirtywhite rounded-2" style="padding: 8px 14px;">
          <div class="d-flex flex-row align-items-center gap-3">
            <img src="public/img/avatar.jpg" alt="avatar" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover; object-position: 0% 25%;" />
            <div class="d-flex flex-column gap-0">
              <p class="fw-bold mb-0">Prese Hoarder</p>
              <p class="mb-0 opacity-75" style="font-size: 12px;">prese.horder@placeholder.com</p>
            </div>
          </div>
          <a href="/group1/dashboard" class="btn btn-sm px-3 btn-navy rounded-1 d-flex align-items-center justify-content-center">Details</a>
        </div>
        <?php endfor; ?>
      </div>
      <div class="text-center fw-semibold">
        <a href="/group1/dashboard" class="text-navy viewer">View All</a>
        <style>.viewer {text-decoration: none;} .viewer:hover {text-decoration: underline;}</style>
      </div>
    </div>
  </div>

</div>

<!-- (~) Courses & Subjects Row -->
<div class="d-flex flex-row gap-3">

  <!-- (~) Courses Column -->
  <div class="d-flex flex-column gap-3 container-fluid m-0 p-0">
    <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Top Courses</p>
    <!-- (~) Courses Column Content -->
    <div class="container-fluid m-0 p-0 p-3 bg-white shadow-sm rounded-3">
      <div class="d-flex flex-column gap-1">
        <?php $opacity = ['100', '75', '50'];
        for ($i = 1; $i <= 3; $i++): ?>
        <div class="d-flex flex-row justify-content-between align-items-center bg-dirtywhite rounded-2" style="padding: 8px 14px;">
          <div class="d-flex flex-row align-items-center gap-3">
            <p class="mb-0 fw-bold roboto-mono-bold opacity-<?= $opacity[$i - 1]; ?>" style="font-size: 18px;">#<?= $i; ?></p>
            <div class="d-flex flex-column gap-0">
              <p class="fw-bold mb-0">BS in Information Technology (BSIT)</p>
              <p class="mb-0 opacity-75 roboto-mono-regular" style="font-size: 12px;">
                500
                <span class="mb-0 opacity 75 roboto-regular" style="font-size: 12px;"> Enrolled</span>
              </p>
            </div>
          </div>
          <a href="/group1/dashboard" class="btn btn-sm px-3 btn-navy rounded-1 h-100 d-flex align-items-center justify-content-center">Details</a>
        </div>
        <?php endfor; ?>
      </div>
      <div class="text-center fw-semibold mt-4">
        <a href="/group1/dashboard" class="text-navy viewer">View All</a>
        <style>.viewer {text-decoration: none;} .viewer:hover {text-decoration: underline;}</style>
      </div>

    </div>
  </div>

  <!-- (~) Subjects Column -->
  <div class="d-flex flex-column gap-3 container-fluid m-0 p-0">
    <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Subjects</p>
    <!-- (~) Subjects Content -->
    <div class="container-fluid m-0 p-0 p-3 bg-white shadow-sm rounded-3">
      <div class="d-flex flex-column gap-1">
        <?php $opacity = ['100', '75', '50'];
        for ($i = 1; $i <= 3; $i++): ?>
        <div class="d-flex flex-row justify-content-between align-items-center bg-dirtywhite rounded-2" style="padding: 8px 14px;">
          <div class="d-flex flex-row align-items-center gap-3">
            <div class="d-flex flex-column gap-0">
              <p class="fw-bold mb-0">Programming in the Modern World</p>
              <div class="d-flex flex-row gap-1 align-items-center">
                <i class="bi bi-book-half opacity-75" style="font-size: 12px;"></i>
                <p class="mb-0 opacity-75 roboto-mono-regular" style="font-size: 12px;">PROG101</p>
                <p class="mb-0 opacity-75 roboto-mono-regular" style="font-size: 12px;">•</p>
                <p class="mb-0 opacity-75 roboto-mono-regular" style="font-size: 12px;">
                  500
                  <span class="mb-0 opacity 75 roboto-regular" style="font-size: 12px;"> Enrolled</span>
                </p>
              </div>

            </div>
          </div>
          <a href="/group1/dashboard" class="btn btn-sm px-3 btn-navy rounded-1 h-100 d-flex align-items-center justify-content-center">Details</a>
        </div>
        <?php endfor; ?>
      </div>
      <div class="text-center fw-semibold mt-4">
        <a href="/group1/dashboard" class="text-navy viewer">View All</a>
        <style>.viewer {text-decoration: none;} .viewer:hover {text-decoration: underline;}</style>
      </div>
    </div>
  </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- (~) Chart.js Source -->
<script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script> <!-- (~) Grid.js Source -->

<!-- (~) Grid.js Script -->
<script>

</script>

<!-- (~) Chart.js Script -->
<script>
  const studentChart = document.getElementById('studentChart');

  new Chart(studentChart, {
    type: 'bar',
    data: {
      labels: ['First Year', 'Second Year', 'Third Year', 'Fourth Year'],
      datasets: [{
        label: 'Number of Students',
        data: <?= json_encode(array_column($studentsByYear, 'count')) ?>,
        backgroundColor: '#222849',
      }],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            font: {
              size: 14,
              family: 'Roboto Mono, monospace',
            },
            stepSize: 1,
          }
        },
      },
    },
  });
</script>