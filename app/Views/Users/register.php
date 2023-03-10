<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
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
                <div class="h3"><b>Register Bank Sampah</b></div>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Silahkan isi data register berikut :</p>
                <form  id="formRegister" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="customer_name" class="form-control" placeholder="Nama Lengkap" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
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
                            <button type="submit" id="btnRegister" class="btn btn-info btn-block">Register</button>
                        </div>
                    </div>
                    <a href="<?php echo base_url('user') ?>" class="text-center text-white">Sudah punya akun? Login disini</a>
                </form>
            </div>
        </div>
    </div>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/templates/adminlte320/js/adminlte.min.js"></script>
  
    <script>
      $(document).ready(function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true
        });
        $('#tampil_password').click(function() {
          if ($(this).is(':checked')) {
            $('#password').attr('type', 'text');
          } else {
            $('#password').attr('type', 'password');
          }
        });

        //Register Sistem
        $('#btnRegister').on('click', function(e) {
          e.preventDefault();
          const formRegister = $('#formRegister');
          $.ajax({
            url: "/Auth/create",
            method: "POST",
            data: formRegister.serialize(),
            dataType: "JSON",
            success: function(data) {
              if (data.error) {
                if (data.register_error['customer_name'] != '') $('#customer_name_error').html(data.register_error['customer_name']);
                else $('#customer_name_error').html('');
                if (data.register_error['username'] != '') $('#username_error').html(data.register_error['username']);
                else $('#username_error').html('');
                if (data.register_error['password'] != '') $('#password_error').html(data.register_error['password']);
                else $('#password_error').html('');
              }
              if (data.success) {
                formRegister.trigger('reset');
                $('#user_name_error').html('');
                $('#username_error').html('');
                $('#password_error').html('');
                Toast.fire({
                  icon: 'success',
                  title: 'Register Anda berhasil.'
                }).then(() => {
                  window.location.replace(data.link);
                });
              }
            }
          });
        });
      });
    </script>
</body>
</html>