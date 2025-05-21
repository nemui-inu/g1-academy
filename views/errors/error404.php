<?php
require_once 'layout/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404 - Page Not Found</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: #fff;
    }
    img {
      width: 100%;
      height: 100%;
    }
  </style>
</head>
<body>
  <img src="/group1/public/img/error404.jpg" alt="404 Not Found">
  <a href="dashboard" class="btn btn-navy" style="position: absolute; margin-top: 350px;">Return Home</a>
</body>
</html>