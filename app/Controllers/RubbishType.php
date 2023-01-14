<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TypeModel;
use Config\Services;

class RubbishType extends BaseController
{
    protected $ModelType;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->ModelType       = new TypeModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data Jenis | Hallyu Sampah!";
        $data['menu']      = "data_jenis";
        $data['page']      = "Jenis";
        $data['user_name'] = $this->session->get('user_name');
        $data['level']     = $this->session->get('level');
        $data['photo']     = $this->session->get('photo');
        return view('Admin/jenis', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_type)
    {
        $link = 
            "<a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_type . "'>
	      		<button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalType'><i class='fa fa-edit'></i></button>
	      	</a>
            <a href='" . base_url('RubbishType/delete/' . $id_type) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		<button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
            </a>";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_type)
    {
        $data = $this->ModelType->find($id_type);
        echo json_encode($data);
    }

    // Simpan data Type
    public function save()
    {
        $type_name = $this->request->getPost('type_name');

        $data_validasi = [
            'type_name' => $type_name
        ];

        //Cek Validasi Data Type, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'type') == FALSE) {
            $validasi = [
                'error'   => true,
                'type_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            $data = [
                'type_name' => $type_name
            ];
            $this->ModelType->save($data);
            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Update data Type
    public function update()
    {
        $id         = $this->request->getPost('id_type');
        $type_name = $this->request->getPost('type_name');

        $data_validasi = [
            'type_name' => $type_name
        ];

        //Cek Validasi data Type, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'type') == FALSE) {

            $validasi = [
                'error'       => true,
                'type_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            $data = [
                'type_name' => $type_name
            ];
            $this->ModelType->update($id, $data);
            $validasi = [
                'success' => true
            ];
            echo json_encode($validasi);
        }
    }

    // Hapus data Type
    public function delete($id_type)
    {
        $this->ModelType->delete($id_type);
    }

    // Tampilkan data Type
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->ModelType->get_datatables();
            $data = [];
            $no = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $list->type_name;
                $row[]  = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->ModelType->count_all(),
                "recordsFiltered" => $this->ModelType->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
