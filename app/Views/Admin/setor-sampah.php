<?= $this->extend('/Layouts/Admin/layout') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Transaksi Setor Sampah</h1>
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
              <table id="tabel-rubbish-deposit" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Nama Nasabah</th>
                    <th>No Telepon</th>
                    <th>Nama Sampah</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Total</th>
                    <th>Alamat</th>
                    <th>Tgl. Penjemputan</th>
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

  <div class="modal fade" id="modalSetorSampah" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formSetorSampah" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id_deposit" id="id_deposit">
            <input type="hidden" name="id_customer" id="id_customer">
            <input type="hidden" name="id_rubbish" id="id_rubbish">
            <div class="form-group">
              <label>Nama Customer</label>
              <input type="text" class="form-control" id="customer_name" name="customer_name" autocomplete="off" placeholder="Masukkan nama nasabah" readonly>
            </div>
            <div class="form-group">
              <label>Nama Sampah</label>
              <input type="text" class="form-control" id="rubbish_name" name="rubbish_name" autocomplete="off" placeholder="Masukkan nama sampah" readonly>
            </div>
            <div class="form-group">
              <label>Harga</label>
              <div class="input-group">
                <input type="text" class="form-control" id="price" name="price" autocomplete="off" placeholder="Masukkan satuan sampah" readonly>
                <div class="input-group-append">
                  <span class="input-group-text" id="unit_name"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input type="text" class="form-control" id="total_deposit" name="total_deposit" autocomplete="off" placeholder="Masukan jumlah" readonly>
            </div>
            <div class="form-group">
              <label>Total</label>
              <input type="text" class="form-control" id="total" name="total" autocomplete="off" placeholder="Masukkan total" readonly>
              <small id="total_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Tgl. Penjemputan</label>
              <input type="text" class="form-control" id="date_delivery" name="date_delivery" placeholder="Masukkan tanggal penjemputan" readonly>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select class="form-control" id="status" name="status" autocomplete="off">
                <option value="">-- Pilih Status --</option>
                <option value="Waiting">Menunggu</option>
                <option value="Successfully">Berhasil</option>
                <option value="Failed">Gagal</option>
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

        // Menampilkan data sampah
        var table = $('#tabel-rubbish-deposit').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/RubbishDeposit/loadDataAdmin",
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
                    "width": '80px',
                    "className": 'text-center',
                },
                {
                    "targets": [4],
                    "width": '100px',
                },
                {
                    "targets": [5],
                    "width": '50px',
                    "className": 'text-center',
                    "render": function(data, type, row) {
                        var btn = data + " " + row[6];
                        return btn;
                    }
                },
                {
                    "targets": [6],
                    "width": '100px',
                    "visible": false,
                },
                {
                    "targets": [7],
                    "width": '100px',
                    "className": 'text-right',
                    render: $.fn.DataTable.render.number('.', ',', 0, 'Rp. '),
                },
                {
                    "targets": [8],
                    "width": '100px',
                },
                {
                    "targets": [9],
                    "width": '100px',
                    "className": 'text-center',
                },
                {
                    "targets": [10],
                    "width": '80px',
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
                    "targets": [11],
                    "orderable": false,
                    "width": '80px',
                    "className": 'text-center',
                },
            ],
        });

        $('body').on('click', '.btnEdit', function() {
            $('#modalLabel').text('Edit Data Setor Sampah');
            var data = table.row($(this).parents('tr')).data();
            var date_delivery = data[7];
            const id_deposit = $(this).attr('value');
            $.ajax({
                url: "/RubbishDeposit/show_transaksi/" + id_deposit,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    condole.log(data);
                    $('#id_deposit').val(data.id);
                    $('#id_customer').val(data.id_customer);
                    $('#id_rubbish').val(data.id_rubbish);
                    $('#customer_name').val(data.customer_name);
                    $('#rubbish_name').val(data.rubbish_name);
                    $('#price').val(convertToRupiah(data.price));
                    $('#unit_name').text('/' + data.unit_name);
                    $('#total_deposit').val(data.total_deposit);
                    $('#total').val(convertToRupiah(data.total));
                    $('#date_delivery').val(date_delivery);
                    $('#status').val(data.status);
                    $('#modalSetorSampah').modal('show');
                }
            })
        });

        // Simpan data ke database
        $('#btnSimpan').on('click', function() {
            // Jika form input data sampah yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Edit Data Setor Sampah") {
                var data = new FormData($("#formSetorSampah")[0]);
                $.ajax({
                    url: "/RubbishDeposit/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.error) {
                          if (data.rubbish_deposit_error['status'] != '') $('#status_error').html(data.rubbish_deposit_error['status']);
                          else $('#status_error').html('');
                        }
                        if (data.success) {
                          $('#formSetorSampah')[0].reset();
                          $('#modalSetorSampah').modal('hide');
                          $('#status_error').html('');
                          $('#tabel-rubbish-deposit').DataTable().ajax.reload();
                          Toast.fire({
                            icon: 'success',
                            title: 'Data Setor Sampah berhasil diupdate.'
                          })
                        }
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>