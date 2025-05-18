<?php
    include_once 'layout/components/frame_head.php';

    if (isset($_SESSION['user']) && isset($_SESSION['user']['role'])) {
        $user_role = $_SESSION['user']['role'];

        $database = new Database();
        $conn = $database->getConnection();

        $dashboard = new Dashboard($conn);
        $dashboard->loadDashboardData($user_role);

        switch ($user_role) {
            case 'instructor':
                include_once 'dash_instruct.php';
                break;
            case 'super-admin':
            case 'admin':
            default:
                include_once 'dash_admin.php';
                break;
        }
    } else {
        echo "Unauthorized access. Please log in.";
        header("Location: auth/login.php");
        exit();
    }

    include_once 'layout/components/frame_foot.php';
?>
     