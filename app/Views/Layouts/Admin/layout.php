<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <link href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css" rel="stylesheet">
  <link href="/assets/plugins/chosen/css/chosen.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/plugins/datepicker/css/datepicker.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="/assets/templates/adminlte320/css/adminlte.min.css">
  <script src="/assets/plugins/jquery/jquery.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?= $this->include('Layouts/Admin/navbar') ?>
    <?= $this->include('Layouts/Admin/sidebar') ?> 
    <?= $this->renderSection('content') ?>

    <footer class="main-footer">
      <center>
        Hallyu Sampah! Copyright &copy; 2023
      </center>
    </footer>
  </div>
  <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Moment -->
    <script src="/assets/plugins/moment/moment.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!--  Chosen Select -->
    <script src="/assets/plugins/chosen/js/chosen.jquery.js"></script>
    <!-- datepicker Plugin JS -->
    <script src="/assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- DataTables -->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/templates/adminlte320/js/adminlte.min.js"></script>
    <!-- Costume JS -->
    <script src="/assets/config/fungsi_validasi_karakter.js"></script>
    <script src="/assets/config/fungsi_format_rupiah.js"></script>
    <!-- page script -->
    <?= $this->renderSection('script') ?>

    <script type="text/javascript">
        $(document).ready(function() {
            bsCustomFileInput.init();
            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true
            });
            $('.chosen-select').chosen();
            $("#logout").click(function() {
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Anda akan keluar dari aplikasi.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Batalkan',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout'
                }).then(function(result) {
                    if (result.value) {
                        window.location = "logout";
                    }
                })
            });
        });
    </script>
</body>
</html>