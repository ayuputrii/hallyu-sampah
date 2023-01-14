<?= $this->extend('/Layouts/Admin/dashboard-layout') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Pengaturan Profil</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <form id="formAdmin" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <input type="hidden" name="id_user" id="id_user" value="<?= $id; ?>">
                      <div class="form-group">
                        <label>Nama User</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" autocomplete="off" readonly>
                        <small id="user_name_error" class="text-danger"></small>
                      </div>
                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" id="username" name="username" autocomplete="off" readonly>
                        <small id="username_error" class="text-danger"></small>
                      </div>
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan password jika tidak diubah" autocomplete="off" readonly>
                        <small id="password_error" class="text-danger"></small>
                      </div>
                      <div class="form-group">
                        <label>Level</label>
                        <input type="text" class="form-control" id="level" name="level" autocomplete="off" readonly>
                        <small id="level_error" class="text-danger"></small>
                      </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Foto</label>
                        <div id="photo_profile" class="custom-file" style="display: none;">
                          <input id="photo" name="photo" type="file" class="custom-file-input" onchange="previewFoto(this);">
                          <label class="custom-file-label" for="photo">Choose file</label>
                          <small id="photo_error" class="text-danger"></small>
                        </div>
                        <br>
                        <div class="mt-3" id="imagePreview">
                          <img class="img-circle profile-user-img foto-preview" alt="photo-profile">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="form-group col-md-6 mt-2">
                    <button type="button" class="btn btn-primary" id="btnUbah">Ubah</button>
                    <button type="button" class="btn btn-primary mr-2" id="btnSimpan">Simpan</button>
                    <button type="button" class="btn btn-danger" id="btnBatal">Batal</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="text/javascript">
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
        tampil_data();
        $('#btnSimpan').hide();
        $('#btnBatal').hide();

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        function convertDateDBtoIndo(string) {
            tanggal = string.split("-")[2];
            bulan   = string.split("-")[1];
            tahun   = string.split("-")[0];

            return tanggal + "-" + bulan + "-" + tahun;
        }

        function tampil_data() {
            var id_user = $('#id_user').val();
            $.ajax({
                url: "/Profile/show/" + id_user,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_user').val(data.id);
                    $('#user_name').val(data.user_name);
                    $('#username').val(data.username);
                    $('#level').val(data.level);
                    $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
                    $('#imagePreview').show();
                    if (data.photo == '') {
                        $('.foto-preview').attr('src', '/images/user/no_image.gif');
                    } else {
                        $('.foto-preview').attr('src', '/images/user/' + data.photo);
                    }
                }
            })
        }

        $('#btnUbah').click(function() {
            $('#btnUbah').hide();
            $('#btnSimpan').show();
            $('#btnBatal').show();
            $('#user_name').removeAttr('readonly');
            $('#user_name').removeAttr('readonly');
            $('#username').removeAttr('readonly');
            $('#password').removeAttr('readonly');
            $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
            $('#photo_profile').removeAttr('style');
        });

        // Simpan data ke database
        $('#btnSimpan').on('click', function() {
            var data = new FormData($("#formAdmin")[0]);
            $.ajax({
                url: "/Profile/update_profile_admin",
                method: "POST",
                data: data,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    // error 
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
                    // berhasil disimpan
                    if (data.success) {
                        $('#formAdmin')[0].reset();
                        $('#modalUser').modal('hide');
                        $('#user_name_error').html('');
                        $('#username_error').html('');
                        $('#level_error').html('');
                        $('#password_error').html('');
                        $('#photo_error').html('');
                        Toast.fire({
                            icon: 'success',
                            title: 'Pengaturan Profil berhasil diupdate.'
                        })
                        tampil_data();
                        disable_form();
                    }
                }
            });
        });

        $('#btnBatal').click(function() {
            tampil_data();
            disable_form();
        });

        function disable_form() {
            $('#btnUbah').show();
            $('#btnSimpan').hide();
            $('#btnBatal').hide();
            $('#user_name').attr('readonly', 'true');
            $('#username').attr('readonly', 'true');
            $('#password').attr('readonly', 'true');
            $('#password').val('');
            $('#password').attr('placeholder', 'Kosongkan password jika tidak diubah');
            $('#photo_profile').attr('style', 'display:none;');
        }

    });
</script>
<?= $this->endSection() ?>