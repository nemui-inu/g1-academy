<?php declare(strict_types=1); ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is logged in
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (!isset($_SESSION['user']) && $path !== '/group1/login') {
    header('Location: /group1/login');
    exit;
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>G1 Academy</title>
  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="/group1/node_modules/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/group1/node_modules/bootstrap-icons/font/bootstrap-icons.css" />

  <!-- Toastr -->
  <link rel="stylesheet" href="/group1/node_modules/toastr/build/toastr.min.css" />

  <!-- Your Custom Styles -->
  <link rel="stylesheet" href="/group1/public/css/main.min.css" />

  <!-- AG Grid -->
  <script src="/group1/node_modules/ag-grid-community/dist/ag-grid-community.min.js"></script>

  <!-- External Stylesheets -->
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="node_modules/toastr/build/toastr.min.css">
  <link rel="stylesheet" href="public/css/main.min.css">

  <!-- External Scripts -->
  <script src="node_modules/ag-grid-community/dist/ag-grid-community.min.js"></script>

  <!-- Custom Styles -->
  <style>
    .card-box {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #007bff;
    }

    .details-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .details-btn:hover {
        background-color: #0056b3;
    }

    .text-end a {
        text-decoration: none;
        color: #007bff;
    }

    .text-end a:hover {
        text-decoration: underline;
    }

    .bg-navy {
        background-color: #1e2a5a;
        color: #ffffff;
    }

    .roboto-mono {
        font-family: 'Roboto Mono', monospace;
    }

    body.bg-dirtywhite {
        background-color: #f8f9fa;
    }
  </style>
</head>
<body class="bg-dirtywhite">
