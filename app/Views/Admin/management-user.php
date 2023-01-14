<?= $this->extend('Layouts/Admin/layout') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Management User</h1>
        </div>
        <div class="col-sm-6">
          <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalUser" role="button">
            <i class="fas fa-plus"></i> Tambah Data
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline">
            <div class="card-body table-responsive">
              <table id="tabel-user" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Foto</th>
                    <th>Nama User</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalUser" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-edit title-icon"></i><span id="modalLabel"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formUser" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id_user" id="id_user">
            <div class="form-group">
              <label>Nama User</label>
              <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Masukkan nama user" autocomplete="off">
              <small id="user_name_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" autocomplete="off">
              <small id="username_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" autocomplete="off">
              <small id="password_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Level</label>
              <select class="form-control" id="level" name="level" autocomplete="off" required placeholder="Pilih Level">
                <option value="">-- Pilih Level --</option>
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
              </select>
              <small id="level_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Foto</label>
              <div class="custom-file">
                <input id="photo" name="photo" type="file" class="custom-file-input" onchange="previewFoto(this);" placeholder="Masukkan photo">
                <label class="custom-file-label" for="photo">Choose file</label>
                <small id="photo_error" class="text-danger"></small>
              </div>
              <br>
              <div class="mt-3" id="imagePreview">
                <img class="img-circle profile-user-img foto-preview" alt="photo">
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary mr-2" id="btnSimpan">Simpan</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function previewFoto(input) {
        var file = $("#photo").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $('#imagePreview').show();
                $(".foto-preview").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        // Menampilkan data user
        var table = $('#tabel-user').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Users/loadData",
                "type": "POST"
            },
            responsive: {
                details: {
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            return col.hidden ?
                                '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                '<td>' + col.title + ':' + '</td> ' +
                                '<td>' + col.data + '</td>' +
                                '</tr>' :
                                '';
                        }).join('');

                        return data ?
                            $('<table/>').append(data) :
                            false;
                    }
                }
            },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false,
                    "width": '30px',
                    "className": 'text-center',
                },
                {
                    "targets": [1],
                    "orderable": false,
                    "width": '50px',
                    "className": 'text-center',
                    "render": function(data, type, row) {
                        if (data == '') {
                            return "<img class='img-circle' src='/images/user/no_image.gif' style='height:50px;width:50px;align:middle;'/>";
                        } else {
                            return '<img src="/images/user/' + data + '"style="height:50px;width:50px;align:middle;" class="img-circle" />';
                        }
                    }
                },
                {
                    "responsivePriority": 1,
                    "targets": [2],
                    "width": '100px',
                },
                {
                    "targets": [3],
                    "width": '150px',
                },
                {
                    "targets": [4],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "responsivePriority": 2,
                    "targets": [5],
                    "orderable": false,
                    "width": '50px',
                    "className": 'text-center',
                },
            ],
        });

        // Tampilkan Modal Form Input Data
        $('#btnTambah').click(function() {
            $('#imagePreview').hide();
            $('#formUser')[0].reset();
            $('#password').attr('placeholder', '');
            $('#modalLabel').text('Input Data User');
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            $('#modalLabel').text('Edit Data User');
            const id_user = $(this).attr('value');
            $.ajax({
                url: "/Users/show/" + id_user,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_user').val(data.id);
                    $('#user_name').val(data.user_name);
                    $('#username').val(data.username);
                    $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
                    $('#level').val(data.level);
                    $('#imagePreview').show();
                    if (data.photo == '') {
                        $('.foto-preview').attr('src', '/images/user/no_image.gif');
                    } else {
                        $('.foto-preview').attr('src', '/images/user/' + data.photo);
                    }
                    $('#modalUser').modal('show');
                }
            })
        });

        // Simpan data ke database
        $('#btnSimpan').on('click', function() {
            // Jika form input data user yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Data User") {
                var data = new FormData($("#formUser")[0]);
                $.ajax({
                    url: "/Users/save",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.user_error['user_name'] != '') $('#user_name_error').html(data.user_error['user_name']);
                            else $('#user_name_error').html('');
                            if (data.user_error['username'] != '') $('#username_error').html(data.user_error['username']);
                            else $('#username_error').html('');
                            if (data.user_error['password'] != '') $('#password_error').html(data.user_error['password']);
                            else $('#password_error').html('');
                            if (data.user_error['level'] != '') $('#level_error').html(data.user_error['level']);
                            else $('#level_error').html('');
                            if (data.user_error['photo'] != '') $('#photo_error').html(data.user_error['photo']);
                            else $('#photo_error').html('');
                        }
                        //Data user berhasil disimpan
                        if (data.success) {
                            $('#formUser')[0].reset();
                            $('#modalUser').modal('hide');
                            $('#user_name_error').html('');
                            $('#username_error').html('');
                            $('#password_error').html('');
                            $('#level_error').html('');
                            $('#photo_error').html('');
                            $('#tabel-user').DataTable().ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data User berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            } else if ($('#modalLabel').text() == "Edit Data User") {
                var data = new FormData($("#formUser")[0]);
                $.ajax({
                    url: "/Users/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.user_error['user_name'] != '') $('#user_name_error').html(data.user_error['user_name']);
                            else $('#user_name_error').html('');
                            if (data.user_error['username'] != '') $('#username_error').html(data.user_error['username']);
                            else $('#username_error').html('');
                            if (data.user_error['level'] != '') $('#level_error').html(data.user_error['level']);
                            else $('#level_error').html('');
                            if (data.user_error['photo'] != '') $('#photo_error').html(data.user_error['photo']);
                            else $('#photo_error').html('');
                        }
                        //Data user berhasil disimpan
                        if (data.success) {
                            $('#formUser')[0].reset();
                            $('#modalUser').modal('hide');
                            $('#user_name_error').html('');
                            $('#username_error').html('');
                            $('#level_error').html('');
                            $('#photo_error').html('');
                            $('#tabel-user').DataTable().ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data User berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            }
        });

        // Hapus data user
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data user ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        method: "POST",
                        success: function(response) {
                            $('#tabel-user').DataTable().ajax.reload()
                            // tutup sweet alert
                            swal.close();
                            // tampilkan pesan sukses hapus data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data User berhasil dihapus.'
                            })
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>