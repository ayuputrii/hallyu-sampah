<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use Config\Services;

class Customers extends BaseController
{
    protected $ModelCustomer;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->ModelCustomer   = new CustomerModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data Nasabah | Hallyu Sampah!";
        $data['menu']      = "";
        $data['page']      = "nasabah";
        $data['user_name'] = $this->session->get('user_name');
        $data['level']     = $this->session->get('level');
        $data['photo']     = $this->session->get('photo');
        return view('Admin/nasabah', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_customer)
    {
        $link = 
            "<a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_customer . "'>
	      	    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalcustomers'><i class='fa fa-edit'></i></button>
	      	</a>
            <a href='" . base_url('Customers/delete/' . $id_customer) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      	    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
            </a>";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_customer)
    {
        $data = $this->ModelCustomer->find($id_customer);
        echo json_encode($data);
    }

    // Update data customers
    public function update()
    {
        $id            = $this->request->getPost('id_customer');
        $customer_name = $this->request->getPost('customer_name');
        $address       = $this->request->getPost('address');
        $phone         = $this->request->getPost('phone');
        $photo         = $this->request->getFile('photo');

        $data_validasi = [
            'customer_name' => $customer_name,
            'address'       => $address,
            'phone'         => $phone,
            'photo'         => $photo
        ];

        //Cek Validasi data customers, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'update_customer') == FALSE) {
            $validasi = [
                'error'           => true,
                'customers_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            if ($photo == '') {
                $data = [
                    'customer_name' => $customer_name,
                    'address'       => $address,
                    'phone'         => $phone
                ];
                $this->ModelCustomer->update($id, $data);
                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file photo peserta ke direktori public/customers
                $nama_photo = $photo->getRandomName();
                $photo->move('images/customer', $nama_photo);
                $data = [
                    'customer_name' => $customer_name,
                    'address'       => $address,
                    'phone'         => $phone,
                    'photo'         => $nama_photo
                ];
                // hapus photo lama
                $old_photo = $this->ModelCustomer->find($id);
                if ($old_photo['photo'] == true) {
                    unlink('images/customer/' . $old_photo['photo']);
                }

                $this->ModelCustomer->update($id, $data);
                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Hapus data customers
    public function delete($id_customer)
    {
        $data = $this->ModelCustomer->find($id_customer);
        // delete photo
        if ($data['photo'] == true) {
            unlink('images/customer/' . $data['photo']);
        }
        $this->ModelCustomer->delete($id_customer);
    }

    // Tampilkan data customers
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->ModelCustomer->get_datatables();
            $data  = [];
            $no    = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $list->photo;
                $row[]  = $list->customer_name;
                $row[]  = $list->address;
                $row[]  = $list->phone;
                $row[]  = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->ModelCustomer->count_all(),
                "recordsFiltered" => $this->ModelCustomer->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
