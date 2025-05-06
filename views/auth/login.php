<div class="w-100 vh-100 bg-dirtywhite d-flex d-column justify-content-center align-items-center">
  <!-- (~) Invisible Card -->
  <div class="w-100 d-flex flex-column gap-5 justify-content-center align-items-center" style="max-width: 275px;">
    <!-- (~) Logo Type -->
    <div class="row gx-3" style="max-width: 275px;">
      <div class="col-6">
        <img src="public/svg/logo-2.svg" alt="G1 Academy Logo" class="img-fluid" style="width: 100px; height: auto;" />
      </div>
      <div class="col-6 d-flex flex-column gap-0 margin-0 fw-bold fs-5 text-navy">
        <p class="m-0 lh-1">Student</p>
        <p class="m-0 lh-1">Management</p>
        <p class="m-0 lh-1">System</p>
      </div>
    </div>
    <!-- (~) Headings -->
    <p class="text-center fw-semibold text-navy m-0" style="font-size: 18px;">Login to your account</p>
    
    <!-- (~) Form -->
    <form action="/group1/login" method="post" class="w-100 d-flex flex-column">
      <div class="d-flex flex-column gap-3">
        <!-- (~) Error -->
        <?php if (!empty($_SESSION['error'])): ?>
          <div class="d-flex flex-column gap-2">
            <div class="w-100 alert alert-danger px-3 py-2 m-0 bg-red text-white" role="alert">
              <p class="fw-semibold me-2 mb-0">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Access Denied
              </p>
            </div>
            <div class="w-100 alert alert-danger px-3 py-2 m-0 bg-red text-white" role="alert">
              <?=
              $_SESSION['error'];
              unset($_SESSION['error']);
              ?>
            </div>
          </div>
        <?php endif; ?>
        <input type="email" name="email" class="form-control px-3 border-1 border-navy rounded-3" placeholder="Email" required />
        <input type="password" name="password" class="form-control px-3 border-1 border-navy rounded-3" placeholder="Password" required />
        <button type="submit" class="btn btn-navy text-white fw-semibold rounded-3">Login</button>
      </div>
    </form>
  </div>
</div>
   