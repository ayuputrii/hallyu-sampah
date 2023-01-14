<?= $this->extend('/Layouts/Users/index') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Rekening</h1>
        </div>
        <div class="col-sm-6">
          <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalRekening" role="button">
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
              <table id="tabel-account" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Bank</th>
                    <th>No. Rekening</th>
                    <th>Atas Nama</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
              <tbody>
              </tbody>
            </table>
          </div>
         </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalRekening" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formAccount" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id_acccount" id="id_acccount">
            <input type="hidden" name="id_customer" id="id_customer" value="<?= $id; ?>">
            <div class="form-group">
              <label>Nama Bank</label>
              <input type="text" class="form-control" id="bank_name" name="bank_name" autocomplete="off" placeholder="Masukkan nama bank">
              <small id="bank_name_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>No. Rekening</label>
              <input type="text" class="form-control" id="account_number" name="account_number" autocomplete="off" placeholder="Masukkan nomor rekening">
              <small id="account_number_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Atas Nama</label>
              <input type="text" class="form-control" id="the_name_of" name="the_name_of" autocomplete="off" placeholder="Masukkan atas nama">
              <small id="the_name_of_error" class="text-danger"></small>
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
    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        // Menampilkan data rekening
        var table = $('#tabel-account').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Account/loadData",
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
                    "responsivePriority": 1,
                    "targets": [1],
                    "width": '100px',
                    "className": 'text-center',

                },
                {
                    "targets": [2],
                    "width": '100px',
                    "className": 'text-center',

                },
                {
                    "responsivePriority": 1,
                    "targets": [3],
                    "width": '100px',
                    "className": 'text-center',

                },
                {
                    "responsivePriority": 2,
                    "targets": [4],
                    "orderable": false,
                    "width": '50px',
                    "className": 'text-center',
                },
            ],
        });

        // Tampilkan Modal Form Input Data
        $('#btnTambah').click(function() {
            $('#formAccount')[0].reset();
            $('#modalLabel').text('Input Data Rekening');
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            $('#modalLabel').text('Edit Data Rekening');
            const id_acccount = $(this).attr('value');
            $.ajax({
                url: "/Account/show/" + id_acccount,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_acccount').val(data.id);
                    $('#bank_name').val(data.bank_name);
                    $('#account_number').val(data.account_number);
                    $('#the_name_of').val(data.the_name_of);
                    $('#modalRekening').modal('show');
                }
            })
        });

        // Simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data rekening yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Data Rekening") {
                var data = new FormData($("#formAccount")[0]);
                $.ajax({
                    url: "/Account/save",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.account_error['bank_name'] != '') $('#bank_name_error').html(data.account_error['bank_name']);
                            else $('#bank_name_error').html('');
                            if (data.account_error['account_number'] != '') $('#account_number_error').html(data.account_error['account_number']);
                            else $('#account_number_error').html('');
                            if (data.account_error['the_name_of'] != '') $('#the_name_of_error').html(data.account_error['the_name_of']);
                            else $('#the_name_of_error').html('');
                        }
                        //Data rekening berhasil disimpan
                        if (data.success) {
                            $('#formAccount')[0].reset();
                            $('#modalRekening').modal('hide');
                            $('#bank_name_error').html('');
                            $('#account_number_error').html('');
                            $('#the_name_of_error').html('');
                            $('#tabel-account').DataTable().ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Rekening berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            } else if ($('#modalLabel').text() == "Edit Data Rekening") {
                var data = new FormData($("#formAccount")[0]);
                $.ajax({
                    url: "/Account/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.account_error['bank_name'] != '') $('#bank_name_error').html(data.account_error['bank_name']);
                            else $('#bank_name_error').html('');
                            if (data.account_error['account_number'] != '') $('#account_number_error').html(data.account_error['account_number']);
                            else $('#account_number_error').html('');
                            if (data.account_error['the_name_of'] != '') $('#the_name_of_error').html(data.account_error['the_name_of']);
                            else $('#the_name_of_error').html('');
                        }
                        //Data rekening berhasil disimpan
                        if (data.success) {
                            $('#formAccount')[0].reset();
                            $('#modalRekening').modal('hide');
                            $('#bank_name_error').html('');
                            $('#account_number_error').html('');
                            $('#the_name_of_error').html('');
                            $('#tabel-account').DataTable().ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Rekening berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            }
        });

        // Hapus data rekening
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data rekening ini?",
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
                            $('#tabel-account').DataTable().ajax.reload()
                            swal.close();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Rekening berhasil dihapus.'
                            })
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>