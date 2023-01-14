<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountModel;
use Config\Services;

class Account extends BaseController
{
    protected $ModelAccount;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->ModelAccount    = new AccountModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']         = "Data Rekening | Hallyu Sampah!";
        $data['menu']          = "";
        $data['page']          = "rekening";
        $data['id']            = $this->session->get('id');
        $data['customer_name'] = $this->session->get('customer_name');
        $data['balance']       = $this->session->get('balance');
        $data['photo']         = $this->session->get('photo');
        return view('Users/rekening', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_account)
    {
        $link = 
            "<a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_account . "'>
	      		<button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalRekening'><i class='fa fa-edit'></i></button>
	      	</a>
            <a href='" . base_url('Account/delete/' . $id_account) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      	    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
            </a>";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_account)
    {
        $data = $this->ModelAccount->find($id_account);
        echo json_encode($data);
    }

    // Simpan data rekening
    public function save()
    {
        $id_customer  = $this->request->getPost('id_customer');
        $bank_name   = $this->request->getPost('bank_name');
        $account_number = $this->request->getPost('account_number');
        $the_name_of   = $this->request->getPost('the_name_of');

        $data_validasi = [
            'bank_name'   => $bank_name,
            'account_number' => $account_number,
            'the_name_of'   => $the_name_of
        ];

        //Cek Validasi Data Rekening, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'account') == FALSE) {

            $validasi = [
                'error'   => true,
                'account_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            //data rekening
            $data = [
                'id_customer'  => $id_customer,
                'bank_name'   => $bank_name,
                'account_number' => $account_number,
                'the_name_of'   => $the_name_of
            ];
            //Simpan data rekening
            $this->ModelAccount->save($data);

            $validasi = [
                'success'   => true
            ];
            echo json_encode($validasi);
        }
    }

    // Update data rekening
    public function update()
    {
        $id             = $this->request->getPost('id_account');
        $bank_name      = $this->request->getPost('bank_name');
        $account_number = $this->request->getPost('account_number');
        $the_name_of    = $this->request->getPost('the_name_of');

        $data_validasi = [
            'bank_name'      => $bank_name,
            'account_number' => $account_number,
            'the_name_of'    => $the_name_of
        ];

        //Cek Validasi data rekening, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'account') == FALSE) {

            $validasi = [
                'error'         => true,
                'account_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            //data rekening
            $data = [
                'bank_name'      => $bank_name,
                'account_number' => $account_number,
                'the_name_of'    => $the_name_of
            ];
            //Update data rekening
            $this->ModelAccount->update($id, $data);

            $validasi = [
                'success' => true
            ];
            echo json_encode($validasi);
        }
    }

    // Hapus data rekening
    public function delete($id_account)
    {
        $this->ModelAccount->delete($id_account);
    }

    // tampilkan data rekening
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->ModelAccount->get_datatables();
            $data  = [];
            $no    = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $list->bank_name;
                $row[]  = $list->account_number;
                $row[]  = $list->the_name_of;
                $row[]  = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->ModelAccount->count_all(),
                "recordsFiltered" => $this->ModelAccount->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
