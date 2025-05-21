<?php
http_response_code(404);
ob_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>404 Not Found</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    html, body {
      height: 100%;
      width: 100%;
      background-color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    img {
      max-width: 100vw;
      max-height: 100vh;
      object-fit: contain;
    }
  </style>
</head>
<body>
  <img src="/group1/public/svg/error404.svg" alt="404 Not Found" />
</body>
</html>
