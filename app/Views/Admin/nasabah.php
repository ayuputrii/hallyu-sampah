<?= $this->extend('/Layouts/Admin/layout') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Nasabah</h1>
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
              <table id="tabel-customer" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Foto</th>
                    <th>Nama Nasabah</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
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

  <div class="modal fade" id="modalCustomer" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-edit title-icon"></i><span id="modalLabel"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formCustomer" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id_customer" id="id_customer">
            <div class="form-group">
              <label>Nama Nasabah</label>
              <input type="text" class="form-control" id="customer_name" name="customer_name" autocomplete="off">
              <small id="customer_name_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <textarea class="form-control" name="address" id="address" rows="3"></textarea>
              <small id="address_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Telepon</label>
              <input type="text" class="form-control" id="phone" name="phone" autocomplete="off">
              <small id="phone_error" class="text-danger"></small>
            </div>
            <div class="form-group">
              <label>Foto</label>
              <div class="custom-file">
                <input id="photo" name="photo" type="file" class="custom-file-input" onchange="previewFoto(this);">
                <label class="custom-file-label" for="photo">Choose file</label>
                  <small id="photo_error" class="text-danger"></small>
              </div>
              <br>
              <div class="mt-3" id="imagePreview">
                <img class="img-circle profile-user-img foto-preview" alt="Photo">
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

        // Menampilkan data nasabah
        var table = $('#tabel-customer').DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/Customers/loadData",
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
                            return "<img class='img-circle' src='/images/customer/no_image.gif' style='height:50px;width:50px;align:middle;'/>";
                        } else {
                            return '<img src="/images/customer/' + data + '"style="height:50px;width:50px;align:middle;" class="img-circle" />';
                        }
                    }
                },
                {
                    "responsivePriority": 1,
                    "targets": [2],
                    "width": '150px',
                },
                {
                    "targets": [3],
                    "width": '200px',
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
            $('#formCustomer')[0].reset();
            $('#modalLabel').text('Input Data Nasabah');
        });

        // Tampilkan Modal Form Edit Data
        $('body').on('click', '.btnEdit', function() {
            $('#modalLabel').text('Edit Data Nasabah');
            const id_customer = $(this).attr('value');
            $.ajax({
                url: "/Customers/show/" + id_customer,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_customer').val(data.id);
                    $('#customer_name').val(data.customer_name);
                    $('#address').val(data.address);
                    $('#phone').val(data.phone);
                    $('#imagePreview').show();
                    if (data.photo == '') {
                        $('.foto-preview').attr('src', '/images/customer/no_image.gif');
                    } else {
                        $('.foto-preview').attr('src', '/images/customer/' + data.photo);
                    }
                    $('#modalCustomer').modal('show');
                }
            })
        });

        // simpan data ke database
        $('#btnSimpan').on('click', function() {
            if ($('#modalLabel').text() == "Edit Data Nasabah") {
                var data = new FormData($("#formCustomer")[0]);
                $.ajax({
                    url: "/Customers/update",
                    method: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        //Data error 
                        if (data.error) {
                            if (data.customer_error['customer_name'] != '') $('#customer_name_error').html(data.customer_error['customer_name']);
                            else $('#customer_name_error').html('');
                            if (data.customer_error['address'] != '') $('#address_error').html(data.customer_error['address']);
                            else $('#address_error').html('');
                            if (data.customer_error['phone'] != '') $('#phone_error').html(data.customer_error['phone']);
                            else $('#phone_error').html('');
                            if (data.customer_error['foto'] != '') $('#photo_error').html(data.customer_error['foto']);
                            else $('#photo_error').html('');
                        }
                        //Data nasabah berhasil disimpan
                        if (data.success) {
                            // reset form
                            $('#formCustomer')[0].reset();
                            $('#modalCustomer').modal('hide');
                            $('#customer_name_error').html('');
                            $('#address_error').html('');
                            $('#phone_error').html('');
                            $('#photo_error').html('');
                            $('#tabel-customer').DataTable().ajax.reload();
                            // tampilkan pesan sukses simpan data
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Nasabah berhasil disimpan.'
                            })
                            $('#imagePreview').hide();
                        }
                    }
                });
            }
        });

        // Hapus data nasabah
        $('body').on('click', '.btnHapus', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Anda ingin menghapus data nasabah ini?",
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
                            $('#tabel-customer').DataTable().ajax.reload()
                            swal.close();
                            Toast.fire({
                                icon: 'success',
                                title: 'Data Nasabah berhasil dihapus.'
                            })
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>