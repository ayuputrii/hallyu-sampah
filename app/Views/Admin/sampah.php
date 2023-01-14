<?= $this->extend('/Layouts/Admin/layout') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Data Sampah</h1>
        </div>
        <div class="col-sm-6">
          <a class="btn btn-primary float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal" data-target="#modalSampah" role="button">
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
              <table id="tabel-rubbish" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Foto</th>
                    <th>Nama Sampah</th>
                    <th>Jenis</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
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

  <div class="modal fade" id="modalSampah" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-edit title-icon"></i> <span id="modalLabel"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formRubbish" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <input type="hidden" name="id_rubbish" id="id_rubbish">
                <div class="form-group">
                  <label>Nama Sampah</label>
                  <input type="text" class="form-control" id="rubbish_name" name="rubbish_name" autocomplete="off" placeholder="Masukkan nama sampah">
                  <small id="rubbish_name_error" class="text-danger"></small>
                </div>
                <div class="form-group">
                  <label>Jenis Sampah</label>
                  <select class="form-control chosen-select" name="id_type" id="id_type">
                    <option value="">-- Pilih Jenis Sampah --</option>
                    <?php foreach ($type as $row) : ?>
                      <option value="<?= $row['id']; ?>"><?= $row['type_name']; ?></option>
                    <?php endforeach ?>
                  </select>
                  <small id="id_type_error" class="text-danger"></small>
                </div>
                <div class="form-group">
                  <label>Satuan</label>
                  <select class="form-control chosen-select" name="id_unit" id="id_unit">
                    <option value="">-- Pilih Satuan Sampah --</option>
                    <?php foreach ($unit as $row) : ?>
                    <option value="<?= $row['id']; ?>"><?= $row['unit_name']; ?></option>
                    <?php endforeach ?>
                  </select>
                  <small id="id_unit_error" class="text-danger"></small>
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea class="form-control" name="desc" id="desc" rows="3" placeholder="Masukkan deskripsi sampah"></textarea>
                  <small id="desc_error" class="text-danger"></small>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Harga</label>
                  <input type="text" class="form-control" id="price" name="price" onKeyPress="return goodchars(event,'0123456789',this)" autocomplete="off" placeholder="Masukkan harga sampah">
                  <small id="price_error" class="text-danger"></small>
                </div>
                <div class="form-group">
                  <label>Stok</label>
                  <input type="number" class="form-control" id="stock" name="stock" autocomplete="off" placeholder="Masukkan stok barang">
                  <small id="stock_error" class="text-danger"></small>
                </div>
                <div class="form-group">
                  <label>Foto</label>
                  <div class="custom-file">
                    <input id="photo" name="photo" type="file" class="custom-file-input" onchange="previewFoto(this);" placeholder="Masukkan foto sampah">
                    <label class="custom-file-label" for="photo">Choose file</label>
                    <small id="photo_error" class="text-danger"></small>
                  </div>
                  <br>
                  <div class="mt-3" id="imagePreview">
                    <img class="img-circle profile-user-img foto-preview" alt="Foto">
                  </div>
                </div>
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
  // Tampilkan preview foto
  function previewFoto(input) {
    var file = $("#foto").get(0).files[0];
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

    // Format Rupiah
    var price = document.getElementById('price');
    price.addEventListener('keyup', function(e) {
      price.value = formatRupiah(this.value); 
    });

    // Menampilkan data sampah
    var table = $('#tabel-rubbish').DataTable({
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "/Rubbish/loadData",
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
              '</tr>' : '';
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
        }, {
          "targets": [1],
          "orderable": false,
          "width": '50px',
          "className": 'text-center',
          "render": function(data, type, row) {
            if (data == '') {
              return "<img class='img-circle' src='/images/sampah/no_image.gif' style='height:50px;width:50px;align:middle;'/>";
            } else {
              return '<img src="/images/sampah/' + data + '"style="height:50px;width:50px;align:middle;" class="img-circle" />';
            }
          }
        }, {
          "responsivePriority": 1,
          "targets": [2],
          "width": '150px',
        }, {
          "targets": [3],
          "width": '100px',
          "className": 'text-center',
        }, {
          "targets": [4],
          "width": '100px',
          "className": 'text-center',
        }, {
          "targets": [5],
          "width": '100px',
          "className": 'text-right',
          render: $.fn.DataTable.render.number('.', ',', 0, 'Rp. '),
        }, {
          "targets": [6],
          "width": '200px',
        }, {
          "targets": [7],
          "width": '100px',
          "className": 'text-center',
        }, {
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
      $('#imagePreview').hide();
      $('#formRubbish')[0].reset();
      $('#id_type').val('').trigger('chosen:updated');
      $('#id_unit').val('').trigger('chosen:updated');
      $('#modalLabel').text('Input Data Sampah');
    });

    // Tampilkan Modal Form Edit Data
    $('body').on('click', '.btnEdit', function() {
      $('#modalLabel').text('Edit Data Sampah');
      var data = table.row($(this).parents('tr')).data();
      const id_rubbish = $(this).attr('value');
      $.ajax({
        url: "/Rubbish/show/" + id_rubbish,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#id_rubbish').val(data.id);
          $('#rubbish_name').val(data.rubbish_name);
          $('#id_type').val(data.id_type).trigger('chosen:updated');
          $('#id_unit').val(data.id_unit).trigger('chosen:updated');
          $('#desc').val(data.desc);
          $('#stock').val(data.stock);
          $('#price').val(convertToRupiah(data.price));
          $('#imagePreview').show();
          if (data.photo == '') {
            $('.foto-preview').attr('src', '/images/sampah/no_image.gif');
          } else {
            $('.foto-preview').attr('src', '/images/sampah/' + data.photo);
          }
          $('#modalSampah').modal('show');
        }
      })
    });

    // Simpan data ke database
    $('#btnSimpan').on('click', function() {
      // Jika form input data sampah yang ditampilkan, jalankan perintah simpan
      if ($('#modalLabel').text() == "Input Data Sampah") {
        var data = new FormData($("#formRubbish")[0]);
        $.ajax({
          url: "/Rubbish/save",
          method: "POST",
          data: data,
          contentType: false,
          cache: false,
          processData: false,
          dataType: "JSON",
          success: function(data) {
            if (data.error) {
              if (data.rubbish_error['rubbish_name'] != '') $('#rubbish_name_error').html(data.rubbish_error['rubbish_name']);
              else $('#rubbish_name_error').html('');
              if (data.rubbish_error['id_type'] != '') $('#id_type_error').html(data.rubbish_error['id_type']);
              else $('#id_type_error').html('');
              if (data.rubbish_error['id_unit'] != '') $('#id_unit_error').html(data.rubbish_error['id_unit']);
              else $('#id_unit_error').html('');
              if (data.rubbish_error['desc'] != '') $('#desc_error').html(data.rubbish_error['desc']);
              else $('#desc_error').html('');
              if (data.rubbish_error['price'] != '') $('#price_error').html(data.rubbish_error['price']);
              else $('#price_error').html('');
              if (data.rubbish_error['stock'] != '') $('#stock_error').html(data.rubbish_error['stock']);
              else $('#stock_error').html('');
              if (data.rubbish_error['foto'] != '') $('#photo_error').html(data.rubbish_error['foto']);
              else $('#photo_error').html('');
            }
            if (data.success) {
              $('#formRubbish')[0].reset();
              $('#modalSampah').modal('hide');
              $('#rubbish_name_error').html('');
              $('#id_type_error').html('');
              $('#id_unit_error').html('');
              $('#desc_error').html('');
              $('#price_error').html('');
              $('#stock_error').html('');
              $('#photo_error').html('');
              $('#tabel-rubbish').DataTable().ajax.reload();
              Toast.fire({
                icon: 'success',
                title: 'Data Sampah berhasil disimpan.'
              })
              $('#imagePreview').hide();
            }
          }
        });
      } else if ($('#modalLabel').text() == "Edit Data Sampah") {
        var data = new FormData($("#formRubbish")[0]);
        $.ajax({
          url: "/Rubbish/update",
          method: "POST",
          data: data,
          contentType: false,
          cache: false,
          processData: false,
          dataType: "JSON",
          success: function(data) {
            if (data.error) {
              if (data.rubbish_error['rubbish_name'] != '') $('#rubbish_name_error').html(data.rubbish_error['rubbish_name']);
              else $('#rubbish_name_error').html('');
              if (data.rubbish_error['id_type'] != '') $('#id_type_error').html(data.rubbish_error['id_type']);
              else $('#id_type_error').html('');
              if (data.rubbish_error['id_unit'] != '') $('#id_unit_error').html(data.rubbish_error['id_unit']);
              else $('#id_unit_error').html('');
              if (data.rubbish_error['desc'] != '') $('#desc_error').html(data.rubbish_error['desc']);
              else $('#desc_error').html('');
              if (data.rubbish_error['price'] != '') $('#price_error').html(data.rubbish_error['price']);
              else $('#price_error').html('');
              if (data.rubbish_error['stock'] != '') $('#stock_error').html(data.rubbish_error['stock']);
              else $('#stock_error').html('');
              if (data.rubbish_error['foto'] != '') $('#photo_error').html(data.rubbish_error['foto']);
              else $('#photo_error').html('');
            }
            if (data.success) {
              $('#formRubbish')[0].reset();
              $('#modalSampah').modal('hide');
              $('#rubbish_name_error').html('');
              $('#id_type_error').html('');
              $('#id_unit_error').html('');
              $('#desc_error').html('');
              $('#price_error').html('');
              $('#stock_error').html('');
              $('#photo_error').html('');
              $('#tabel-rubbish').DataTable().ajax.reload();
              
              // tampilkan pesan sukses simpan data
              Toast.fire({
                icon: 'success',
                title: 'Data Sampah berhasil disimpan.'
              })
              $('#imagePreview').hide();
            }
          }
        });
      }
    });

    $('body').on('click', '.btnHapus', function(e) {
      e.preventDefault();
      const url = $(this).attr('href');
      Swal.fire({
        title: 'Hapus Data?',
        text: "Anda ingin menghapus data sampah ini?",
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
              $('#tabel-rubbish').DataTable().ajax.reload()
              swal.close();
              Toast.fire({
                icon: 'success',
                title: 'Data Sampah berhasil dihapus.'
              })
            }
          });
        }
      });
    });
  });
</script>
<?= $this->endSection() ?>