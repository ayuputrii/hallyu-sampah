<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use App\Models\UserRubbishModel;
use App\Models\AdminRubbishModel;
use App\Models\RubbishModel;
use App\Models\CustomerModel;

class RubbishDeposit extends BaseController
{
    protected $AdminRubbish;
    protected $UserRubbish;
    protected $Rubbish;
    protected $Customer;
    protected $request;
    protected $form_validation;
    protected $session;

	public function __construct()
	{
    $this->request          = Services::request();
    $this->AdminRubbish     = new AdminRubbishModel($this->request);
    $this->UserRubbish      = new UserRubbishModel($this->request);
    $this->Rubbish          = new RubbishModel($this->request);
    $this->Customer         = new CustomerModel($this->request);
    $this->form_validation  = \Config\Services::validation();
    $this->session          = \Config\Services::session();
	}

	// Halaman Dashboard Admin
	public function admin()
	{
		$data['title']	    = "Setor Sampah - Admin | Hallyu Sampah!";
		$data['menu']	  	  = "";
		$data['page']	  	  = "setor-sampah";
    $data['id']         = $this->session->get('id');
		$data['user_name']	= $this->session->get('user_name');
		$data['level']	    = $this->session->get('level');
		$data['photo']	  	= $this->session->get('photo');
		return view('Admin/setor-sampah', $data);
	}

  // Halaman Dashboard User
  public function user()
  {
    $data['title']          = "Setor Sampah | Hallyu Sampah!";
    $data['menu']           = "";
    $data['page']           = "setor-sampah";
    $data['rubbish']        = $this->Rubbish->findAll();
    $data['id']             = $this->session->get('id');
    $data['customer_name']  = $this->session->get('customer_name');
    $data['address']        = $this->session->get('address');
    $data['phone']          = $this->session->get('phone');
    $data['balance']        = $this->session->get('balance');
    $data['photo']          = $this->session->get('photo');
    return view('Users/setor-sampah', $data);
  }

  // Tombol Opsi Pada Tabel
  private function _action_user($id_deposit)
  {
    $link = 
    "<a href='" . base_url('RubbishDeposit/delete/' . $id_deposit) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
      <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
    </a>";
    return $link;
  }

  // Tombol Opsi Pada Tabel
  private function _action_admin($id_deposit)
  {
    $link = 
    "<a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_deposit . "'>
	    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalSetorrubbish'><i class='fa fa-edit'></i></button>
	  </a>";
    return $link;
  }

  // Tampilkan data
  public function show_rubbish($id_rubbish)
  {
    $db      = \Config\Database::connect();
    $builder = $db->table('tb_rubbish a');
    $builder->select('a.price, b.unit_name');
    $builder->join('tb_rubbish_unit b', 'a.id_unit = b.id', 'left');
    $builder->where('a.id', $id_rubbish);
    $data = $builder->get();
    foreach ($data->getResult() as $row) {
      echo json_encode($row);
    }
  }

  public function show_customer($id_customer)
  {
    $data = $this->Customer->find($id_customer);
    echo json_encode($data);
  }
    
  public function show_transaksi($id_deposit)
  {
    $db      = \Config\Database::connect();
    $builder = $db->table('tb_rubbish_deposit a');
    $builder->select('a.id, a.id_customer, a.id_rubbish, b.customer_name, c.rubbish_name, c.price, d.unit_name, a.total_deposit, a.total, a.date_delivery, a.status');
    $builder->join('tb_customers b', 'a.id_customer = b.id', 'left');
    $builder->join('tb_rubbish c', 'a.id_rubbish = c.id', 'left');
    $builder->join('tb_rubbish_unit d', 'c.id_unit = d.id', 'left');
    $builder->where('a.id', $id_deposit);
    $data = $builder->get();
    foreach ($data->getResult() as $row) {
      echo json_encode($row);
    }
  }

  // Simpan data rubbish
  public function save()
  {
    $id_customer    = $this->request->getPost('id_customer');
    $id_rubbish     = $this->request->getPost('id_rubbish');
    $total_deposit  = $this->request->getPost('total_deposit');
    $total          = str_replace('.', '', trim($this->request->getPost('total')));
    $date_delivery  = trim(date('Y-m-d', strtotime($this->request->getPost('date_delivery'))));

    $data_validasi = [
      'id_rubbish'      => $id_rubbish,
      'total_deposit'   => $total_deposit,
      'total'           => $total,
      'date_delivery'   => $date_delivery
    ];

    //Cek Validasi Data rubbish, Jika Data Tidak Valid 
    if ($this->form_validation->run($data_validasi, 'rubbish_deposit_user') == FALSE) {
      $validasi = [
       'error'   => true,
       'rubbish_deposit_error' => $this->form_validation->getErrors()
      ];
      echo json_encode($validasi);
    } else {
      $data = [
        'id_customer'     => $id_customer,
        'id_rubbish'      => $id_rubbish,
        'total_deposit'   => $total_deposit,
        'total'           => $total,
        'date_delivery'   => $date_delivery,
      ];
      //Simpan data rubbish
      $this->UserRubbish->save($data);
      $validasi = [
        'success'   => true
      ];
      echo json_encode($validasi);
    }
  }

  // Update data setor
  public function update()
  {
    $id             = $this->request->getPost('id_deposit');
    $status         = $this->request->getPost('status');
    $id_rubbish     = $this->request->getPost('id_rubbish');
    $data_rubbish   = $this->Rubbish->find($id_rubbish);
    $total_deposit  = $this->request->getPost('total_deposit');
    $stock          = $data_rubbish['stock'] + $total_deposit;
    $id_customer    = $this->request->getPost('id_customer');
    $data_customer  = $this->Customer->find($id_customer);
    $total          = str_replace('.', '', trim($this->request->getPost('total')));
    $balance        = $data_customer['balance'] + $total;

    //data rubbish_deposit
    $data_validasi = [
      'status' => $status
    ];
    
    //Cek Validasi data rubbish_deposit, Jika Data Tidak Valid 
    if ($this->form_validation->run($data_validasi, 'rubbish_deposit_admin') == FALSE) {
      $validasi = [
        'error'   => true,
        'rubbish_deposit_error' => $this->form_validation->getErrors()
      ];
      echo json_encode($validasi);
    } else {
      if ($status != 'Berhasil') {
        $data_rubbish_deposit = [
          'status' => $status
        ];
        //Update data rubbish_deposit
        $this->AdminRubbish->update($id, $data_rubbish_deposit);            
        $validasi = [
          'success' => true
        ];
        echo json_encode($validasi);
      } else {
        $data_rubbish = [
          'stock' => $stock
        ];
        $this->Rubbish->update($id_rubbish, $data_rubbish);
        $data_customer = [
          'balance' => $balance
        ];
        $this->Customer->update($id_customer, $data_customer);
        $data_rubbish_deposit = [
          'status' => $status
        ];
        $this->AdminRubbish->update($id, $data_rubbish_deposit);
        $validasi = [
          'success' => true
        ];
        echo json_encode($validasi);
      }
    }
  }

  // Hapus data rubbish
  public function delete($id_deposit)
  {
    $this->UserRubbish->delete($id_deposit);
  }

  // Tampilkan data rubbish
  public function loadDataAdmin()
  {
    if ($this->request->getMethod(true) == 'POST') {
      $lists = $this->AdminRubbish->get_datatables();
      $data  = [];
      $no    = $this->request->getPost("start");
      foreach ($lists as $list) {
        $no++;
        $row    = [];
        $row[]  = $no;
        $row[]  = date("d-m-Y H:i:s", strtotime($list->datetime));
        $row[]  = $list->customer_name;
        $row[]  = $list->phone;
        $row[]  = $list->rubbish_name;
        $row[]  = $list->total_deposit;
        $row[]  = $list->unit_name;
        $row[]  = $list->total;
        $row[]  = $list->address;
        $row[]  = date("d-m-Y", strtotime($list->date_delivery));
        $row[]  = $list->status;
        $row[]  = $this->_action_admin($list->id);
        $data[] = $row;
      }
      $output = [
        "draw"            => $this->request->getPost('draw'),
        "recordsTotal"    => $this->AdminRubbish->count_all(),
        "recordsFiltered" => $this->AdminRubbish->count_filtered(),
        "data"            => $data
      ];
      echo json_encode($output);
    }
  }

  // Tampilkan data rubbish
  public function loadDataUser()
  {
    if ($this->request->getMethod(true) == 'POST') {
      $lists = $this->UserRubbish->get_datatables();
      $data  = [];
      $no    = $this->request->getPost("start");
      foreach ($lists as $list) {
        $no++;
        $row    = [];
        $row[]  = $no;
        $row[]  = date("d-m-Y H:i:s", strtotime($list->datetime));
        $row[]  = $list->rubbish_name;
        $row[]  = $list->total_deposit;
        $row[]  = $list->unit_name;
        $row[]  = $list->total;
        $row[]  = date("d-m-Y", strtotime($list->date_delivery));
        $row[]  = $list->status;
        $row[]  = $this->_action_user($list->id);
        $data[] = $row;
      }
      $output = [
        "draw"            => $this->request->getPost('draw'),
        "recordsTotal"    => $this->UserRubbish->count_all(),
        "recordsFiltered" => $this->UserRubbish->count_filtered(),
        "data"            => $data
      ];
      echo json_encode($output);
    }
  }
}