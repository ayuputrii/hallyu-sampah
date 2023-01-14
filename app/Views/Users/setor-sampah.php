<?= $this->extend('/Layouts/Users/index') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Transaksi Setor Sampah</h1>
        </div>
        <div class="col-sm-6">
          <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalSetorSampah" role="button">
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
              <table id="tabel-rubbish-deposit" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Nama Sampah</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Total</th>
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
        <form id="formRubbishDeposit" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id_deposit" id="id_deposit">
            <input type="hidden" name="id_customer" id="id_customer" value="<?= $id; ?>">
            <input type="hidden" name="address" id="address">
            <input type="hidden" name="phone" id="phone">
            <div class="form-group">
              <label>Nama Sampah</label>
              <select class="form-control chosen-select" name="id_rubbish" id="id_rubbish" placeholder="Masukkan nama sampah">
                <option value="" disabled>-- Pilih --</option>
                <?php foreach ($rubbish as $row) : ?>
                  <option value="<?= $row['id']; ?>"><?= $row['rubbish_name']; ?></option>
                <?php endforeach ?>
              </select>
              <small id="id_rubbish_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Harga</label>
              <div class="input-group">
                <input type="text" class="form-control" id="price" name="price" readonly placeholder="Masukkan harga">
                <div class="input-group-append">
                    <span class="input-group-text" id="unit_name"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input type="number" class="form-control" id="total_deposit" name="total_deposit" min="1" autocomplete="off" placeholder="Masukkan jumlah">
              <small id="total_deposit_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Total</label>
              <input type="number" class="form-control" id="total" name="total" autocomplete="off" readonly placeholder="Masukkan total">
              <small id="total_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Tgl. Penjemputan</label>
              <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="date_delivery" name="date_delivery" value="<?php echo date("d-m-Y"); ?>" placeholder="Masukkan tanggal penjemputan">
              <small id="date_delivery_error" class="text-danger"></small>
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
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/RubbishDeposit/loadDataUser",
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
                },
                {
                    "targets": [3],
                    "width": '100px',
                    "className": 'text-center',
                    "render": function(data, type, row) {
                        var btn = data + " " + row[4];
                        return btn;
                    }
                },
                {
                    "targets": [4],
                    "width": '100px',
                    "visible": false,
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

        // Tampilkan Modal Form Input Data
        $('#btnTambah').click(function() {
            $('#formRubbishDeposit')[0].reset();
            $('#id_rubbish').val('').trigger('chosen:updated');
            $('#modalLabel').text('Input Data Setor Sampah');
            const id_customer = $('#id_customer').val();;
            $.ajax({
                url: "/RubbishDeposit/show_customer/" + id_customer,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#address').val(data.address);
                    $('#phone').val(data.phone);
                }
            })
        });

        // Tampilkan data
        $('#id_rubbish').change(function() {
            const id_rubbish = $('#id_rubbish').val();;
            $.ajax({
                url: "/RubbishDeposit/show_rubbish/" + id_rubbish,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#price').val(convertToRupiah(data.price));
                    $('#type_name').text('/' + data.type_name);
                }
            })
        });

        // Hitung total
        $('#total_deposit').on('change keyup', function() {
            var price = convertToAngka($('#price').val());
            var total_deposit = $('#total_deposit').val();
            var total = total_deposit * price;
            $('#total').val(convertToRupiah(total));
        });

        // Simpan data ke database
        $('#btnSimpan').on('click', function() {
            // Jika form input data sampah yang ditampilkan, jalankan perintah simpan
            if ($('#modalLabel').text() == "Input Data Setor Sampah") {
                var address = $('#address').val();
                var phone = $('#phone').val();
                if (address == '' && phone == '') {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Lengkapi data Anda di pengaturan profil dulu.'
                    })
                } else {
                    var data = new FormData($("#formRubbishDeposit")[0]);
                    $.ajax({
                        url: "/RubbishDeposit/save",
                        method: "POST",
                        data: data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data) {
                            // data error disimpan
                            if (data.error) {
                                if (data.rubbish_deposit_error['id_rubbish'] != '') $('#id_rubbish_error').html(data.rubbish_deposit_error['id_rubbish']);
                                else $('#id_rubbish_error').html('');
                                if (data.rubbish_deposit_error['total_deposit'] != '') $('#total_deposit_error').html(data.rubbish_deposit_error['total_deposit']);
                                else $('#total_deposit_error').html('');
                                if (data.rubbish_deposit_error['total'] != '') $('#total_error').html(data.rubbish_deposit_error['total']);
                                else $('#total_error').html('');
                                if (data.rubbish_deposit_error['date_delivery'] != '') $('#date_delivery_error').html(data.rubbish_deposit_error['date_delivery']);
                                else $('#date_delivery_error').html('');
                            }
                            // data berhasil disimpan
                            if (data.success) {
                                $('#formRubbishDeposit')[0].reset();
                                $('#modalSetorSampah').modal('hide');
                                $('#id_rubbish_error').html('');
                                $('#total_deposit_error').html('');
                                $('#total_error').html('');
                                $('#date_delivery_error').html('');
                                $('#tabel-rubbish-deposit').DataTable().ajax.reload();
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Transaksi Setor Sampah berhasil disimpan.'
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
            var status = data[7];
            if (status != 'Waiting') {
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
                                $('#tabel-rubbish-deposit').DataTable().ajax.reload()
                                swal.close();
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Transaksi Setor Sampah berhasil dihapus.'
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