<?= $this->extend('/Layouts/Users/index') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Transaksi Penarikan</h1>
        </div>
        <div class="col-sm-6">
          <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalTransaction" role="button">
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
              <table id="tabel-transaction" class="table table-bordered table-striped">
                  <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Nama Bank</th>
                    <th>No. Rekening</th>
                    <th>Jumlah</th>
                    <th>Tgl. Verikasi</th>
                    <th>Status</th>
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

  <div class="modal fade" id="modalTransaction" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formTransaction" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id_transaction" id="id_transaction">
            <input type="hidden" name="id_customer" id="id_customer" value="<?= $id; ?>">
            <div class="form-group">
              <label>Sisa saldo</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" class="form-control" id="balance" name="balance" value="<?= number_format($balance, 0, ".", "."); ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label>Rekening</label>
              <select class="form-control chosen-select" name="id_account" id="id_account">
                <option value="">-- Pilih --</option>
                <?php foreach ($account as $row) : ?>
                  <option value="<?= $row['id']; ?>"><?= $row['bank_name']; ?> | <?= $row['account_number']; ?> | <?= $row['the_name_of']; ?></option>
                <?php endforeach ?>
              </select>
              <small id="id_account_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" class="form-control" id="total" name="total" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off">
              </div>
              <small id="total_error" class="text-danger"></small>
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

        // Format rupiah
        var total = document.getElementById('total');
        total.addEventListener('keyup', function(e) {
            total.value = formatRupiah(this.value);
        });

        // Menampilkan data sampah
        var table = $('#tabel-transaction').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Transaction/loadDataUser",
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
                        return data ? $('<table/>').append(data) : false;
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
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "responsivePriority": 1,
                    "targets": [2],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "targets": [3],
                    "width": '200px',
                    "className": 'text-center',
                },
                {
                    "targets": [4],
                    "width": '100px',
                    "className": 'text-right',
                    render: $.fn.DataTable.render.number('.', ',', 0, 'Rp. '),
                },
                {
                    "targets": [5],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "targets": [6],
                    "width": '100px',
                    "className": 'text-center',
                    "render": function(data, type, row) {
                        switch (data) {
                            case 'Waiting':
                                return '<span class="badge bg-warning">' + data + '</span>';
                                break;
                            case 'Successfully':
                                return '<span class="badge bg-success">' + data + '</span>';
                                break;
                            case 'Failed':
                                return '<span class="badge bg-danger">' + data + '</span>';
                                break;
                        }
                    }
                },
                {
                    "responsivePriority": 2,
                    "targets": [7],
                    "orderable": false,
                    "width": '80px',
                    "className": 'text-center',
                },
            ],
        });

        // Tampilkan Modal Form Input Data
        $('#btnTambah').click(function() {
            $('#formTransaction')[0].reset();
            $('#modalLabel').text('Input Penarikan');
        });

        // Simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data sampah yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Penarikan") {
                var balance = convertToAngka($('#balance').val());
                var total = convertToAngka($('#total').val());

                if (eval(total) > eval(balance)) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Jumlah tidak boleh melebihi sisa saldo'
                    })
                } else {
                    var data = new FormData($("#formTransaction")[0]);
                    $.ajax({
                        url: "/Transaction/create",
                        method: "POST",
                        data: data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data) {
                            //Data error 
                            if (data.error) {
                                if (data.transaction_error['id_account'] != '') $('#id_account_error').html(data.transaction_error['id_account']);
                                else $('#id_account_error').html('');
                                if (data.transaction_error['total'] != '') $('#total_error').html(data.transaction_error['total']);
                                else $('#total_error').html('');
                            }
                            //Data sampah berhasil disimpan
                            if (data.success) {
                                $('#formTransaction')[0].reset();
                                $('#modalTransaction').modal('hide');
                                $('#id_account_error').html('');
                                $('#total_error').html('');
                                $('#tabel-transaction').DataTable().ajax.reload();
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Transaksi Penarikan berhasil disimpan.'
                                })
                            }
                        }
                    });
                }


            }
        });

        // Hapus data sampah
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            var data = table.row($(this).parents('tr')).data();
            var status = data[6];
            if (status != 'Menunggu') {
                // tampilkan pesan gagal hapus data
                Toast.fire({
                    icon: 'error',
                    title: 'Data Transaksi tidak bisa dihapus.'
                })
            } else {
                const url = $(this).attr('href');
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Anda ingin menghapus data transaksi ini?",
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
                                $('#tabel-transaction').DataTable().ajax.reload()
                                swal.close();
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Transaksi Penarikan berhasil dihapus.'
                                })
                            }
                        });
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>