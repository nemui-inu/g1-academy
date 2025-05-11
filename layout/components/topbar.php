<?php
$name = $_SESSION['user']['name'];
$role = $_SESSION['user']['role'];

$name = strtolower($name);
$name = ucfirst($name);

// (~) Get first name only
$arr = explode(' ', $name);
$name = $arr[0];

$role = strtolower($role);
$role = ucfirst($role);

?>

<!-- (~) Content Header + Breadcrumbs -->
<div class="w-100 bg-white shadow-sm ps-4 pe-2 py-2 rounded-3 d-flex flex-row justify-content-between align-items-center">
  <div class="d-flex flex-row gap-3 align-items-center">
    <?php
    $paths = $_SESSION['path'];

    $count = 0;

    foreach ($paths as $display => $path) {
      if ($count == count($paths) - 1) {
        echo '<a href="' . $path . '" class="mb-0 fw-bold text-navy py-2 text-decoration-none">' . $display . '</a>';
      } else {
        echo '<a href="' . $path . '" class="mb-0 fw-bold text-navy py-2 text-decoration-none opacity-75">' . $display . '</a>';
      }
      if ($count++ < count($paths) - 1) {
        echo '<i class="bi bi-arrow-right"></i>';
      }
    }
    ?>
  </div>
  <div class="d-flex flex-row gap-3 align-items-center">
    <p class="mb-0 fw-semibold text-navy opacity-75">Logged in as: </p>
    <div class="bg-dirtywhite rounded-2 py-2 px-3 d-flex flex-row gap-2 align-items-center">
      <i class="bi bi-person-circle text-navy opacity-75"></i>
      <p class="mb-0 fw-semibold text-navy opacity-75"><?= $name; ?></p>
      <span class="mb-0 fw-semibold text-navy opacity-50">/</span>
      <span class="mb-0 fw-semibold text-navy opacity-50"><?= $role; ?></span>
    </div>
  </div>
</div>