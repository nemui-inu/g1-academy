<?php
include '../../layout/header.php';
?>

<div class="w-100 vh-100 bg-navy d-flex justify-content-center align-items-center">
  <div class="bg-cream text-navy p-4 rounded-4 shadow-sm d-flex flex-column gap-4 align-items-center justify-content-center" style="width: 350px; height: auto;">
    <div class="row gx-1">
      <div class="col-6">
        <img src="../../public/svg/logo-2.svg" alt="G1 Academy Logo" class="img-fluid" style="width: 100px; height: auto;" />
      </div>
      <div class="col-6 d-flex flex-column gap-0 margin-0 fw-bold fs-5">
        <p class="m-0 lh-1">Student</p>
        <p class="m-0 lh-1">Management</p>
        <p class="m-0 lh-1">System</p>
      </div>
    </div>
    <form action="#" method="post" class="w-100 d-flex flex-column gap-4 fw-bold">
      <div class="d-flex flex-column gap-3">
        <div>
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control font-monospace fw-bold rounded-3 border-navy" id="username" name="username" placeholder="John Doe" required />
        </div>
        <div>
          <label for="username" class="form-label">Password</label>
          <input type="password" class="form-control font-monospace fw-bold rounded-3 border-navy" id="password" name="password" placeholder="Password" required />
        </div>
      </div>
      <div>
        <button type="submit" class="btn btn-yellow-2 w-100 text-navy fw-bold rounded-3">LOGIN</button>
      </div>
    </form>
  </div>
</div>

<?php
include '../../layout/footer.php';
?>