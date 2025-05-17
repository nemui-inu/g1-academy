<?php 
  $_SESSION['page'] = 'subjects';
  include '../../layout/header.php';
  include '../../layout/components/frame_head.php'; 
?>

<div class="d-flex flex-column gap-3">
  <div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-bold text-navy mb-0">Subjects</h2>
    <button class="btn btn-outline-secondary rounded-3" disabled>Export</button>
  </div>

  <div class="bg-white shadow-sm rounded-4 p-4">
    <div class="d-flex justify-content-between mb-3">
      <h5 class="fw-semibold text-navy">Subject List</h5>
      <input type="text" class="form-control w-25" placeholder="Search by Name" disabled />
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Courses</th>
            <th>Year Level</th>
            <th>Enrolled</th>
            <th>Status</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($subjects)): ?>
            <tr>
              <td colspan="7" class="text-center text-muted">No subjects assigned.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($subjects as $subject): ?>
              <tr>
                <td><?= htmlspecialchars($subject->catalog_no) ?></td>
                <td><?= htmlspecialchars($subject->name) ?></td>
                <td>
                  <?php
                    $courseQuery = Model::getConnection()->prepare("SELECT code FROM courses WHERE id = ?");
                    $courseQuery->execute([$subject->course_id]);
                    $course = $courseQuery->fetch();
                    echo htmlspecialchars($course['code'] ?? 'N/A');
                  ?>
                </td>
                <td><?= $subject->year_level ?></td>
                <td>
                  <?php
                    $countQuery = Model::getConnection()->prepare("
                      SELECT COUNT(*) FROM subject_enrollments 
                      WHERE subject_id = ? AND status = 'Enrolled'
                    ");
                    $countQuery->execute([$subject->id]);
                    echo $countQuery->fetchColumn();
                  ?>
                </td>
                <td class="text-muted">Ungraded</td>
                <td class="text-end">
                  <a href="?page=grades&action=show&subject_id=<?= $subject->id ?>" class="btn btn-navy btn-sm rounded-3">
                    <i class="bi bi-eye me-1"></i> Details
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../../layout/components/frame_foot.php'; ?>
<?php include '../../layout/footer.php'; ?>
