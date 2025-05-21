<?php declare(strict_types=1);

require_once 'controllers/DashboardController.php';

// Database connection and controller initialization
$database = new Database();
$conn = $database->getConnection();
$dashboard = new Dashboard($conn);

$user_role = $_SESSION['user']['role'];

$totals = [];
$icons = [];

$totals['Instructors'] = DashboardController::getUserCount('instructor');
$icons[] = '<i class="bi bi-person-workspace opacity-75"></i>';

$totals['Students'] = DashboardController::getStudentCount();
$icons[] = '<i class="bi bi-mortarboard-fill opacity-75"></i>';

$totals['Courses'] = DashboardController::getCourseCount();
$icons[] = '<i class="bi bi-collection-fill opacity-75"></i>';

$totals['Subjects'] = DashboardController::getSubjectCount();
$icons[] = '<i class="bi bi-book-half opacity-75"></i>';

if ($user_role === 'super-admin') {
  $totals = array_merge(['Admins' => DashboardController::getUserCount('admin')], $totals);
  array_unshift($icons, '<i class="bi bi-diagram-3-fill opacity-75"></i>');
}

// Fetch students by year
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

<!-- Dashboard Content Wrapper -->
<div class="dashboard-content">
  <div class="custom-dashboard-container">

    <!-- Totals -->
    <div class="d-flex flex-column gap-3 mb-4">
      <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Totals</p>
      <div class="d-flex flex-row gap-3 flex-wrap">
        <?php $i = 0;
        foreach ($totals as $key => $count): ?>
        <div class="container-fluid m-0 px-4 pt-3 pb-4 bg-white rounded-3 d-flex flex-row gap-0 justify-content-between align-items-center shadow-sm" style="min-width: 200px; flex: 1 1 200px;">
          <p class="mb-0 roboto-mono-bold text-navy lh-1" style="font-size: 34px;"><?= $count ?></p>
          <div class="d-flex flex-row align-items-center justify-content-start gap-2">
            <p class="mb-0 roboto-regular text-navy opacity-75 fw-semibold"><?= $key ?></p>
            <?= $icons[$i++] ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Students & Instructors Row -->
    <div class="d-flex flex-row gap-3 mb-4">

      <!-- Students Column -->
      <div class="d-flex flex-column gap-3 container-fluid m-0 p-0">
        <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Students</p>
        <div class="container-fluid m-0 p-3 bg-white shadow-sm rounded-3">
          <?php
          $studentsData = $dashboard->getStudentsPerYearLevel();
          $courses = array_keys($studentsData);

          // Calculate total students per year level across all courses
          $yearLabels = ['1st Year', '2nd Year', '3rd Year', '4th Year'];
          $studentsByYearData = array_fill(0, count($yearLabels), 0);

          foreach ($studentsData as $courseData) {
            foreach ($yearLabels as $i => $year) {
              if (isset($courseData[$year])) {
                $studentsByYearData[$i] += $courseData[$year];
              }
            }
          }
          ?>
          <select id="course-select" class="form-select mb-3">
            <option value="all" selected>All Courses</option>
            <?php foreach ($courses as $course): ?>
              <option value="<?= htmlspecialchars($course) ?>"><?= htmlspecialchars($course) ?></option>
            <?php endforeach; ?>
          </select>
          <div style="min-height: 300px;">
            <canvas id="studentChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Instructors Column -->
      <div class="d-flex flex-column gap-3 w-50 m-0 p-0">
        <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Instructors</p>
        <div class="container-fluid m-0 bg-white shadow-sm p-3 rounded-3 d-flex flex-column justify-content-between h-100">
          <div class="d-flex flex-column gap-1">
            <?php
            $instructors = $dashboard->getActiveInstructors();

            if (!empty($instructors)) {
              $count = 0;
              foreach ($instructors as $instructor) {
                if ($count >= 6)
                  break;

                $name = htmlspecialchars($instructor['name'] ?? 'N/A');
                $email = htmlspecialchars($instructor['email'] ?? 'N/A');

                echo '
                      <div class="d-flex flex-row justify-content-between align-items-center bg-dirtywhite rounded-2" style="padding: 8px 14px;">
                        <div class="d-flex flex-row align-items-center gap-3">
                          <img src="public/img/avatar.jpg" alt="avatar" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover; object-position: 0% 25%;" />
                          <div class="d-flex flex-column gap-0">
                            <p class="fw-bold mb-0">' . $name . '</p>
                            <p class="mb-0 opacity-75" style="font-size: 12px;">' . $email . '</p>
                          </div>
                        </div>
                        <a href="/group1/dashboard" class="btn btn-sm px-3 btn-navy rounded-1">Details</a>
                      </div>';
                $count++;
              }
            } else {
              echo '<p class="text-muted">No active instructors found.</p>';
            }
            ?>
          </div>
          <div class="text-center fw-semibold mt-3">
            <a href="/group1/dashboard" class="text-navy viewer">View All</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Courses & Subjects Row -->
    <div class="d-flex flex-row gap-3">

      <!-- Courses Column -->
      <div class="d-flex flex-column gap-3 container-fluid m-0 p-0">
        <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Top Courses</p>
        <div class="container-fluid m-0 p-3 bg-white shadow-sm rounded-3">
          <div class="d-flex flex-column gap-1">
            <?php
            $topCourses = $dashboard->getTopCourses();
            $opacity = ['100', '75', '50'];

            if (!empty($topCourses)) {
              $count = 0;
              foreach ($topCourses as $index => $course) {
                if ($count >= 3)
                  break;

                $rank = $index + 1;
                $course_name = htmlspecialchars($course['course_name'] ?? 'N/A');
                $student_count = (int) ($course['student_count'] ?? 0);

                echo '
                      <div class="d-flex flex-row justify-content-between align-items-center bg-dirtywhite rounded-2" style="padding: 8px 14px;">
                        <div class="d-flex flex-row align-items-center gap-3">
                          <p class="mb-0 fw-bold roboto-mono-bold opacity-' . $opacity[$count] . '" style="font-size: 18px;">#' . $rank . '</p>
                          <div class="d-flex flex-column gap-0">
                            <p class="fw-bold mb-0">' . $course_name . '</p>
                            <p class="mb-0 opacity-75 roboto-mono-regular" style="font-size: 12px;">' . $student_count . ' <span class="roboto-regular"> Enrolled</span></p>
                          </div>
                        </div>
                        <a href="/group1/dashboard" class="btn btn-sm px-3 btn-navy rounded-1">Details</a>
                      </div>';
                $count++;
              }
            } else {
              echo '<p class="text-muted">No course data available.</p>';
            }
            ?>
          </div>
          <div class="text-center fw-semibold mt-4">
            <a href="/group1/dashboard" class="text-navy viewer">View All</a>
          </div>
        </div>
      </div>

      <!-- Subjects Column -->
      <div class="d-flex flex-column gap-3 container-fluid m-0 p-0">
        <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Subjects</p>
        <div class="container-fluid m-0 p-3 bg-white shadow-sm rounded-3">
          <div class="d-flex flex-column gap-1">
            <?php
            $subjects = $dashboard->getAllSubjects();
            $opacity = ['100', '75', '50'];
            if (!empty($subjects)) {
              $count = 0;
              foreach ($subjects as $index => $subject) {
                if ($count >= 3)
                  break;

                $name = htmlspecialchars($subject['name'] ?? 'N/A');
                $code = htmlspecialchars($subject['code'] ?? 'N/A');
                $enrolled = isset($subject['student_count']) ? (int) $subject['student_count'] : 0;
                $current_opacity = $opacity[$count] ?? '100';
                ?>
              <div class="d-flex flex-row justify-content-between align-items-center bg-dirtywhite rounded-2" style="padding: 8px 14px;">
                <div class="d-flex flex-row align-items-center gap-3">
                  <p class="mb-0 fw-bold roboto-mono-bold opacity-<?= $current_opacity; ?>" style="font-size: 18px;">#<?= $count + 1; ?></p>
                  <div class="d-flex flex-column gap-0">
                    <p class="fw-bold mb-0"><?= $name; ?></p>
                    <div class="d-flex flex-row gap-1 align-items-center">
                      <i class="bi bi-book-half opacity-75" style="font-size: 12px;"></i>
                      <p class="mb-0 opacity-75 roboto-mono-regular" style="font-size: 12px;"><?= $code; ?></p>
                      <p class="mb-0 opacity-75 roboto-mono-regular" style="font-size: 12px;">•</p>
                      <p class="mb-0 opacity-75 roboto-mono-regular" style="font-size: 12px;"><?= $enrolled; ?> <span class="roboto-regular">Enrolled</span></p>
                    </div>
                  </div>
                </div>
                <a href="/group1/dashboard" class="btn btn-sm px-3 btn-navy rounded-1">Details</a>
              </div>
            <?php
                $count++;
              }
            } else {
              echo '<p class="text-muted mb-0">No subjects found.</p>';
            }
            ?>
          </div>
          <div class="text-center fw-semibold mt-4">
            <a href="/group1/dashboard" class="text-navy viewer">View All</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const studentsData = <?php echo json_encode($studentsData); ?>;
  const yearLabels = ['1st Year', '2nd Year', '3rd Year', '4th Year'];
  const studentsByYearData = <?php echo json_encode($studentsByYearData); ?>;

  const ctx = document.getElementById('studentChart').getContext('2d');
  let combinedChart;

  function createChart(data, label) {
    if (combinedChart) combinedChart.destroy();

    combinedChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: yearLabels,
        datasets: [{
          label: label,
          data: data,
          backgroundColor: '#222849',
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              font: { size: 14, family: 'Roboto Mono, monospace' },
              stepSize: 1,
            }
          }
        }
      }
    });
  }

  createChart(studentsByYearData, 'Students by Year');

  document.getElementById('course-select').addEventListener('change', function () {
    const selectedCourse = this.value;

    if (selectedCourse === 'all') {
      createChart(studentsByYearData, 'Students by Year');
    } else if (studentsData[selectedCourse]) {
      const courseDataObj = studentsData[selectedCourse];
      const courseData = yearLabels.map(year => courseDataObj[year] || 0);
      createChart(courseData, selectedCourse);
    } else {
      createChart(studentsByYearData, 'Students by Year');
    }
  });
</script>
