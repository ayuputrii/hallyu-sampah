<?= $this->extend('/layouts/Admin/layout') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Jenis</h1>
        </div>
        <div class="col-sm-6">
          <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalType" role="button">
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
              <table id="tabel_type" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Jenis</th>
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

  <div class="modal fade" id="modalType" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formType" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id_type" id="id_type">
            <div class="form-group">
              <label>Nama Jenis</label>
              <input type="text" class="form-control" id="type_name" name="type_name" autocomplete="off" placeholder="Masukkan nama jenis">
              <small id="type_name_error" class="text-danger"></small>
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

        // Menampilkan data jenis
        var table = $('#tabel_type').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/RubbishType/loadData",
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
                    "width": '200px',
                },
                {
                    "responsivePriority": 2,
                    "targets": [2],
                    "orderable": false,
                    "width": '50px',
                    "className": 'text-center',
                },
            ],
        });

        // Tampilkan Modal Form Input Data
        $('#btnTambah').click(function() {
            $('#formType')[0].reset();
            $('#modalLabel').text('Input Data Jenis');
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            $('#modalLabel').text('Edit Data Jenis');
            const id_type = $(this).attr('value');
            $.ajax({
                url: "/RubbishType/show/" + id_type,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_type').val(data.id);
                    $('#type_name').val(data.type_name);
                    $('#modalType').modal('show');
                }
            })
        });

        // Simpan data ke Database
        $('#btnSimpan').on('click', function() {
            // Jika form input data jenis yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Data Jenis") {
                var data = new FormData($("#formType")[0]);
                $.ajax({
                    url: "/RubbishType/save",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.error) {
                            if (data.type_error['type_name'] != '') $('#type_name_error').html(data.type_error['type_name']);
                            else $('#type_name_error').html('');
                        }
                        if (data.success) {
                            $('#formType')[0].reset();
                            $('#modalType').modal('hide');
                            $('#type_name_error').html('');
                            $('#tabel_type').DataTable().ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Jenis berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            } else if ($('#modalLabel').text() == "Edit Data Jenis") {
                var data = new FormData($("#formType")[0]);
                $.ajax({
                    url: "/RubbishType/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.error) {
                            if (data.type_error['type_name'] != '') $('#type_name_error').html(data.type_error['type_name']);
                            else $('#type_name_error').html('');
                        }
                        if (data.success) {
                            $('#formType')[0].reset();
                            $('#modalType').modal('hide');
                            $('#type_name_error').html('');
                            $('#tabel_type').DataTable().ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Jenis berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            }
        });

        // Hapus data jenis
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data jenis ini?",
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
                            $('#tabel_type').DataTable().ajax.reload()
                            swal.close();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Jenis berhasil dihapus.'
                            })
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>