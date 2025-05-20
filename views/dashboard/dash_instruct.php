<?php
    require_once 'controllers/DashboardController.php';

    $instructor_id = $_SESSION['user']['user_id'];

    $database = new Database();
    $conn = $database->getConnection();

    $dashboard = new Dashboard($conn);
    $subjects = $dashboard->getInstructorSubjects($instructor_id);
    $schedule = $dashboard->getInstructorSchedules($instructor_id);
    $pendingTasks = $dashboard->getPendingGradingDetails($instructor_id);
?>

<div class="dashboard-content">
    <div class="custom-dashboard-container">
        <!-- Assigned Subjects & Enrolled Students Row -->
        <div class="d-flex flex-row gap-3 mb-4">
            <!-- Class Schedule Chart Column -->
            <div class="d-flex flex-column gap-3 container-fluid m-0 p-0">
                <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Class Schedule</p>
                <div class="container-fluid m-0 p-3 bg-white shadow-sm rounded-3">
                <canvas id="scheduleChart" height="300"></canvas>
                </div>
            </div>

            <!-- Enrolled Students Column -->
            <div class="d-flex flex-column gap-3 w-50 m-0 p-0">
                <p class="mb-0 text-navy fw-bold" style="font-size: 20px;">Enrolled Students</p>
                <div class="container-fluid m-0 bg-white shadow-sm p-3 rounded-3 d-flex flex-column justify-content-between h-100">
                    <div class="d-flex flex-column gap-2">
                        <?php
                        if (!empty($subjects)) {
                            $count = 0;
                            foreach ($subjects as $subject) {
                                if ($count >= 4) break;

                                $name = $subject['name'];
                                $enrolled = (int) $subject['enrolled_students'];

                                echo '
                                <div class="d-flex justify-content-between align-items-center bg-dirtywhite rounded-2 px-3 py-2">
                                    <p class="mb-0 fw-semibold text-navy">' . $name . '</p>
                                    <span class="badge bg-navy">' . $enrolled . ' Enrolled</span>
                                </div>';
                                $count++;
                            }
                        } else {
                            echo "<p class='text-muted'>No enrollment data available.</p>";
                        }
                        ?>
                    </div>
                    <div class="text-center fw-semibold mt-3">
                        <a href="#" class="text-navy viewer small">View enrollment details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Grading Tasks -->
        <p class="mb-2 fw-bold text-navy" style="font-size: 24px;">Pending Grading Tasks</p>
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <div id="pending-grading-message" class="text-muted mb-2"></div>
            <div id="pendingGradingGrid" class="ag-theme-alpine" data-instructor-id="<?= $instructor_id ?>"></div>
        </div>
    </div>
</div>

<!--Script-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-grid.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-alpine.css" />
<script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>

<script src="public/js/pendingGradingDetails.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const scheduleData = <?php echo json_encode($schedule); ?>;

    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    function timeToDecimal(t) {
        const [hour, minute] = t.split(':').map(Number);
        return hour + (minute / 60);
    }

    const colors = [
        '#222849', '#4E5068', '#8B97A3', '#36454F', '#061E45', '#6F8695', '#0EA5E9'
    ];

    const datasets = scheduleData.map((sched, index) => {
        const [startTime, endTime] = sched.time.split('-');
        const start = timeToDecimal(startTime.trim());
        const end = timeToDecimal(endTime.trim());
        const color = colors[index % colors.length];

        return {
            label: `${sched.subject_code} | ${sched.subject_name}`,
            backgroundColor: color,
            borderColor: color,
            borderWidth: 1,
            data: [{
                x: sched.day,
                y: [start, end]
            }]
        };
    });

    const ctx = document.getElementById('scheduleChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: days,
            datasets: datasets
        },
        options: {
            indexAxis: 'x',
            scales: {
                x: {
                    position: 'top',
                    stacked: true,
                    title: {
                        display: true,
                    }
                },
                y: {
                    max: 19,
                    min: 7,
                    reverse:true,
                    ticks: {
                        stepSize: 1,
                        callback: value => {
                            const hour = Math.floor(value);
                            const minutes = (value % 1) * 60;
                            return `${String(hour).padStart(2, '0')}:${minutes === 0 ? '00' : '30'}`;
                        }
                    },
                    title: {
                        display: true,
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: context => {
                            const y = context.raw.y;
                            const format = v => {
                                const hour = Math.floor(v);
                                const minute = (v % 1) * 60;
                                return `${String(hour).padStart(2, '0')}:${minute === 0 ? '00' : '30'}`;
                            };

                            const entry = scheduleData[context.datasetIndex];

                            return `${entry.subject_code} - ${entry.subject_name} (${entry.course_name})\n` +
                                `${format(y[0])} - ${format(y[1])} @ ${entry.room}`;
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>