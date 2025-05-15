<!-- (~) Main Container -->
<div class="w-100 vh-100 bg-dirtywhite">
    <!-- (~) Main Row -->
  <div class="d-flex flex-row gap-3">
    <!-- (~) Sidebar Column -->
    <div class="d-flex flex-column gap-3 p-3 pe-0 vh-100" style="width: 300px;">
      <?php include_once 'layout/components/sidebar.php'; ?>
    </div>
    <!-- (~) Content Column -->
    <div class="d-flex flex-column p-3 ps-0 w-100 gap-4">
      <?php include_once 'layout/components/topbar.php'; ?>
      <!-- (~) Content goes below this point -->
      <div class="w-100 d-flex flex-column gap-4">
        <?php
          if (isset($_SESSION['user']) && isset($_SESSION['user']['role'])) {
            $user_role = $_SESSION['user']['role'];

            $database = new Database();
            $conn = $database->getConnection();

            $dashboard = new Dashboard($conn);
            $dashboard->loadDashboardData($user_role);

            switch ($user_role) {
                case 'instructor':
                    include_once 'views/dashboard/dash_instruct.php';
                    break;
                case 'super-admin':
                case 'admin':
                default:
                    include_once 'views/dashboard/dash_admin.php';
                    break;
            }
          } else {
              echo "Unauthorized access. Please log in.";
              header("Location: login.php");
              exit();
          }
        ?>
