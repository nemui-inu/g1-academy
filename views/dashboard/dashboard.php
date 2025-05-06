<!-- (~) Main Container -->
<div class="w-100 vh-100 bg-dirtywhite">
    <!-- (~) Main Row -->
  <div class="d-flex flex-row gap-3">
    <!-- (~) Sidebar Column -->
    <div class="d-flex flex-column gap-3 p-3 pe-0 vh-100" style="width: 300px;">
      <?php include_once 'layout/components/sidebar.php'; ?>
    </div>
    <!-- (~) Content Column -->
    <div class="d-flex flex-column p-3 ps-0 w-100 gap-3">
      <?php include_once 'layout/components/topbar.php'; ?>
      <!-- (~) Content goes below this point -->
      <div class="w-100">
        <?php include_once 'views/dashboard/dash_admin.php'; ?>
      </div>
    </div>
  </div>
</div>