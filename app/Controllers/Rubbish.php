<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RubbishModel;
use App\Models\TypeModel;
use App\Models\UnitModel;
use Config\Services;

class Rubbish extends BaseController
{
    protected $ModelRubbish;
    protected $ModelType;
    protected $ModelUnit;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request          = Services::request();
        $this->ModelRubbish     = new RubbishModel($this->request);
        $this->ModelType        = new TypeModel($this->request);
        $this->ModelUnit        = new UnitModel($this->request);
        $this->form_validation  = \Config\Services::validation();
        $this->session          = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data Sampah | Hallyu Sampah!";
        $data['menu']      = "data_sampah";
        $data['page']      = "sampah";
        $data['type']      = $this->ModelType->findAll();
        $data['unit']      = $this->ModelUnit->findAll();
        $data['user_name'] = $this->session->get('user_name');
        $data['level']     = $this->session->get('level');
        $data['photo']     = $this->session->get('photo');
        return view('Admin/sampah', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_rubbish)
    {
        $link = 
            "<a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_rubbish . "'>
			    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalSampah'><i class='fa fa-edit'></i></button>
		    </a>
            <a href='" . base_url('Rubbish/delete/' . $id_rubbish) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
			    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
            </a>";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_rubbish)
    {
        $data = $this->ModelRubbish->find($id_rubbish);
        echo json_encode($data);
    }

    // Simpan data rubbish
    public function save()
    {
        $rubbish_name = $this->request->getPost('rubbish_name');
        $id_type      = $this->request->getPost('id_type');
        $id_unit      = $this->request->getPost('id_unit');
        $price        = str_replace('.', '', trim($this->request->getPost('price')));
        $desc         = $this->request->getPost('desc');
        $stock        = $this->request->getPost('stock');
        $photo        = $this->request->getFile('photo');

        $data_validasi = [
            'rubbish_name' => $rubbish_name,
            'id_type'      => $id_type,
            'id_unit'      => $id_unit,
            'price'        => $price,
            'desc'         => $desc,
            'stock'        => $stock,
            'photo'        => $photo
        ];

        //Cek Validasi data rubbish, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'rubbish') == FALSE) {

            $validasi = [
                'error'        => true,
                'rubbish_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            if ($photo == '') {
                $data = [
                    'rubbish_name' => $rubbish_name,
                    'id_type'      => $id_type,
                    'id_unit'      => $id_unit,
                    'price'        => $price,
                    'desc'         => $desc,
                    'stock'        => $stock
                ];
                $this->ModelRubbish->save($data);
                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file photo ke direktori public/sampah
                $nama_photo = $photo->getRandomName();
                $photo->move('images/sampah', $nama_photo);
                //data rubbish
                $data = [
                    'rubbish_name' => $rubbish_name,
                    'id_type'      => $id_type,
                    'id_unit'      => $id_unit,
                    'price'        => $price,
                    'desc'         => $desc,
                    'stock'        => $stock,
                    'photo'        => $nama_photo
                ];
                //Simpan data rubbish
                $this->ModelRubbish->save($data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Update data rubbish
    public function update()
    {
        $id             = $this->request->getPost('id_rubbish');
        $rubbish_name   = $this->request->getPost('rubbish_name');
        $id_type        = $this->request->getPost('id_type');
        $id_unit        = $this->request->getPost('id_unit');
        $price          = str_replace('.', '', trim($this->request->getPost('price')));
        $desc           = $this->request->getPost('desc');
        $stock          = $this->request->getPost('stock');
        $photo          = $this->request->getFile('photo');

        //data rubbish
        $data_validasi = [
            'rubbish_name' => $rubbish_name,
            'id_type'      => $id_type,
            'id_unit'      => $id_unit,
            'price'        => $price,
            'desc'         => $desc,
            'stock'        => $stock,
            'photo'        => $photo
        ];

        //Cek Validasi data rubbish, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'rubbish') == FALSE) {

            $validasi = [
                'error'        => true,
                'rubbish_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            if ($photo == '') {
                //data rubbish
                $data = [
                    'rubbish_name' => $rubbish_name,
                    'id_type'      => $id_type,
                    'id_unit'      => $id_unit,
                    'price'        => $price,
                    'desc'         => $desc,
                    'stock'        => $stock
                ];
                //Update data rubbish
                $this->ModelRubbish->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file photo peserta ke direktori public/sampah
                $nama_photo = $photo->getRandomName();
                $photo->move('images/sampah', $nama_photo);
                //data rubbish
                $data = [
                    'rubbish_name' => $rubbish_name,
                    'id_type'      => $id_type,
                    'id_unit'      => $id_unit,
                    'price'        => $price,
                    'desc'         => $desc,
                    'stock'        => $stock,
                    'photo'        => $nama_photo
                ];
                // hapus photo lama
                $old_photo = $this->ModelRubbish->find($id);
                if ($old_photo['photo'] == true) {
                    unlink('images/sampah/' . $old_photo['photo']);
                }
                //Update data rubbish
                $this->ModelRubbish->update($id, $data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Hapus data rubbish
    public function delete($id_rubbish)
    {
        $data = $this->ModelRubbish->find($id_rubbish);
        // delete photo
        if ($data['photo'] == true) {
            unlink('images/sampah/' . $data['photo']);
        }
        $this->ModelRubbish->delete($id_rubbish);
    }

    // Tampilkan data rubbish
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists  = $this->ModelRubbish->get_datatables();
            $data   = [];
            $no     = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $list->photo;
                $row[]  = $list->rubbish_name;
                $row[]  = $list->type_name;
                $row[]  = $list->unit_name;
                $row[]  = $list->price;
                $row[]  = $list->desc;
                $row[]  = $list->stock;
                $row[]  = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->ModelRubbish->count_all(),
                "recordsFiltered" => $this->ModelRubbish->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
