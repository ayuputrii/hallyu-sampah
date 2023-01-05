
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="/assets/templates/adminlte320/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card bg-info card-outline card-yellow elevation-5">
      <div class="card-header text-center mt-4">
        <div class="login-logo">
          <img class="brand mb-2 img-circle elevation-2" src="/assets/templates/adminlte320/img/img-earth.jpg" height="135" width="135"><br>
        </div>
        <div class="h3"><b>Login Bank Sampah (Admin)</b></div>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Silahkan login untuk masuk ke sistem Admin</p>
        <form action="/Auth/cek_admin_login" method="post">
          <div class="input-group mb-3">
            <input type="username" id="username" name="username" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <small id="username_error" class="form-text text-danger mb-3"></small>
          <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <small id="password_error" class="form-text text-danger mb-3"></small>
          <div class="row">
            <div class="col-8">
              <div class="icheck-yellow">
                <input type="checkbox" id="tampil_password">
                <label for="tampil_password">
                Tampilkan Password
                </label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-info btn-block">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="/assets/plugins/jquery/jquery.min.js"></script>
  <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/templates/adminlte320/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#tampil_password').click(function() {
        if ($(this).is(':checked')) {
          $('#password').attr('type', 'text');
        } else {
          $('#password').attr('type', 'password');
        }
      });
    });
  </script>
</body>
</html>