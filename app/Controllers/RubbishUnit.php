<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnitModel;
use Config\Services;

class RubbishUnit extends BaseController
{
    protected $ModelUnit;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->ModelUnit       = new UnitModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data Satuan | Hallyu Sampah!";
        $data['menu']      = "data_satuan";
        $data['page']      = "Satuan";
        $data['user_name'] = $this->session->get('user_name');
        $data['level']     = $this->session->get('level');
        $data['photo']      = $this->session->get('photo');
        return view('Admin/satuan', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_Unit)
    {
        $link = "
                <a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_Unit . "'>
	      		    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalUnit'><i class='fa fa-edit'></i></button>
	      	    </a>
                <a href='" . base_url('RubbishUnit/delete/' . $id_Unit) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      		    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
                </a>
                ";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_Unit)
    {
        $data = $this->ModelUnit->find($id_Unit);
        echo json_encode($data);
    }

    // Simpan data Unit
    public function save()
    {
        $unit_name = $this->request->getPost('unit_name');

        $data_validasi = [
            'unit_name' => $unit_name
        ];

        //Cek Validasi Data Unit, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'unit') == FALSE) {

            $validasi = [
                'error'      => true,
                'Unit_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            $data = [
                'unit_name' => $unit_name
            ];
            $this->ModelUnit->save($data);
            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Update data Unit
    public function update()
    {
        $id          = $this->request->getPost('id_Unit');
        $unit_name   = $this->request->getPost('unit_name');

        $data_validasi = [
            'unit_name' => $unit_name
        ];

        //Cek Validasi data Unit, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'unit') == FALSE) {
            $validasi = [
                'error'   => true,
                'Unit_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            $data = [
                'unit_name' => $unit_name
            ];
            $this->ModelUnit->update($id, $data);
            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Hapus data Unit
    public function delete($id_Unit)
    {
        $this->ModelUnit->delete($id_Unit);
    }

    // Tampilkan data Unit
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->ModelUnit->get_datatables();
            $data  = [];
            $no    = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $list->unit_name;
                $row[]  = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->ModelUnit->count_all(),
                "recordsFiltered" => $this->ModelUnit->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
