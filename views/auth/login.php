<div class="login-body w-100 vh-100 top-0 start-0 end-0">
  <div class="contrast w-100 vh-100 position-absolute top-0 start-0 end-0 ">
    <div class="row">
      <div class="col-6 top-0 start-0 margin-0 d-flex justify-content-start align-items-start vh-100" style="padding-left: 100px;">
        <img src="public/img/g1-banner.png" alt="" style="height: 55%; width: auto;" class="img-fluid" />
      </div>
      <div class="col-6 d-flex justify-content-center align-items-center vh-100 margin-0" style="padding: 0;">
        <div class="bg-navy text-yellow p-4 rounded-4 shadow shadow-sm d-flex flex-column gap-4 align-items-center justify-content-center" style="width: 350px; height: auto;">
          <div class="row gx-1">
            <div class="col-6">
              <img src="public/svg/logo-yellow.svg" alt="G1 Academy Logo" class="img-fluid" style="width: 100px; height: auto;" />
            </div>
            <div class="col-6 d-flex flex-column gap-0 margin-0 fw-bold fs-5">
              <p class="m-0 lh-1">Student</p>
              <p class="m-0 lh-1">Management</p>
              <p class="m-0 lh-1">System</p>
            </div>
          </div>
          <form action="/group1/login" method="POST" class="w-100 d-flex flex-column gap-4 fw-bold">
            <?php if (!empty($_SESSION['error'])): ?>
              <div class="alert alert-danger mb-0 py-2 px-3 bg-red text-cream border-0 fw-semibold">
                <?=
                $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
              </div>
            <?php endif; ?>
            <div class="d-flex flex-column gap-3">
              <div>
                <label for="username" class="form-label">Email</label>
                <input type="email" class="form-control font-monospace fw-bold rounded-3 border-yellow" id="email" name="email" placeholder="johndoe@email.com" required />
              </div>
              <div class="password-wrapper">
                <label for="username" class="form-label">Password</label>
                <input type="password" class="form-control font-monospace fw-bold rounded-3 border-yellow" id="password" name="password" placeholder="****************" required />
                <button class="peek-toggle" type="button" onclick="togglePassword()"><i class="bi bi-eye-slash" id="toggleIcon"></i></button>
              </div>
            </div>
            <div>
              <button type="submit" class="btn btn-yellow-2 w-100 text-navy fw-bold rounded-3">LOGIN</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>