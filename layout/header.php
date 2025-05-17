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
</head>

<body class="bg-dirtywhite">



  