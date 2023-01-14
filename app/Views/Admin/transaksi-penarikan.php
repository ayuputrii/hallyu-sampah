<?= $this->extend('Layouts/Admin/layout') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Transaksi Penarikan</h1>
        </div>
        <div class="col-sm-6">
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
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Nama Nasabah</th>
                    <th>Nama Bank</th>
                    <th>No. Rekening</th>
                    <th>Jumlah</th>
                    <th>Tgl. Verikasi</th>
                    <th>Status</th>
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

  <div class="modal fade" id="modalPenarikan" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formPenarikan" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id_transaction" id="id_transaction">
            <input type="hidden" name="id_customer" id="id_customer">
            <div class="form-group">
              <label>Nama Nasabah</label>
              <input type="text" class="form-control" id="customer_name" name="customer_name" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label>Nama Bank</label>
              <input type="text" class="form-control" id="bank_name" name="bank_name" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label>No. Rekening</label>
              <input type="text" class="form-control" id="account_number" name="account_number" autocomplete="off" readonly>
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Rp.</span>
                </div>
                <input type="text" class="form-control" id="total" name="total" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off" readonly>
              </div>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select class="form-control" id="status" name="status" autocomplete="off">
                <option value="Menunggu">Menunggu</option>
                <option value="Berhasil">Berhasil</option>
                <option value="Gagal">Gagal</option>
              </select>
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

        // format rupiah
        var total = document.getElementById('total');
        total.addEventListener('keyup', function(e) {
            total.value = formatRupiah(this.value);
        });

        // Menampilkan data sampah
        var table = $('#tabel-transaction').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Transaction/loadDataAdmin",
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
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "responsivePriority": 1,
                    "targets": [2],
                    "width": '100px',
                },
                {
                    "targets": [3],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "targets": [4],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "targets": [5],
                    "width": '100px',
                    "className": 'text-right',
                    render: $.fn.DataTable.render.number('.', ',', 0, 'Rp. '),
                },
                {
                    "targets": [6],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "targets": [7],
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
                    "targets": [8],
                    "orderable": false,
                    "width": '80px',
                    "className": 'text-center',
                },
            ],
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            $('#modalLabel').text('Edit Penarikan');
            const id_transaction = $(this).attr('value');
            $.ajax({
                url: "/Transaction/show_transaksi/" + id_transaction,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_transaction').val(data.id);
                    $('#id_customer').val(data.id_customer);
                    $('#customer_name').val(data.customer_name);
                    $('#bank_name').val(data.bank_name);
                    $('#account_number').val(data.account_number);
                    $('#total').val(convertToRupiah(data.total));
                    $('#status').val(data.status);
                    $('#modalPenarikan').modal('show');
                }
            })
        });

        // Simpan data ke database
        $('#btnSimpan').on('click', function() {
            // jika form input data sampah yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Edit Penarikan") {
                var data = new FormData($("#formPenarikan")[0]);
                $.ajax({
                    url: "/Transaction/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.penarikan_error['status'] != '') $('#status_error').html(data.penarikan_error['status']);
                            else $('#status_error').html('');
                        }
                        //Data sampah berhasil disimpan
                        if (data.success) {
                            $('#formPenarikan')[0].reset();
                            $('#modalPenarikan').modal('hide');
                            $('#status_error').html('');
                            $('#tabel-transaction').DataTable().ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'Transaksi Penarikan berhasil diupdate.'
                            })
                        }
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>