<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserTransactionModel;
use App\Models\AdminTransactionModel;
use App\Models\CustomerModel;
use App\Models\AccountModel;
use Config\Services;

class Transaction extends BaseController
{
  protected $UserTransactionModel;
  protected $AdminTransactionModel;
  protected $ModelCustomer;
  protected $ModelAccount;
  protected $request;
  protected $form_validation;
  protected $session;

  public function __construct()
  {
    $this->request               = Services::request();
    $this->UserTransactionModel  = new UserTransactionModel($this->request);
    $this->AdminTransactionModel = new AdminTransactionModel($this->request);
    $this->ModelCustome          = new CustomerModel($this->request);
    $this->ModelAccount          = new AccountModel($this->request);
    $this->form_validatio        = \Config\Services::validation();
    $this->session               = \Config\Services::session();
  }

  public function admin()
  {
    $data['title']     = "Transaksi Penarikan | Hallyu Sampah!";
    $data['menu']      = "";
    $data['page']      = "transaksi-penarikan";
    $data['id']        = $this->session->get('id');
    $data['user_name'] = $this->session->get('user_name');
    $data['level']     = $this->session->get('level');
    $data['photo']     = $this->session->get('photo');
    return view('Admin/transaksi-penarikan', $data);
  }

  public function user()
  {
    $data['title']        = "Penarikan Saldo | Hallyu Sampah!";
    $data['menu']        = "";
    $data['page']        = "penarikan-saldo";
    $data['id']          = $this->session->get('id');
    $data['customer_name']  = $this->session->get('customer_name');
    $data['balance']      = $this->session->get('balance');
    $data['photo']        = $this->session->get('photo');
    $id_customer          = $this->session->get('id');
    $data['account']      = $this->ModelAccount->where('id_customer', $id_customer)->findAll();
    return view('Users/penarikan-saldo', $data);
  }

  // Tombol Opsi Pada Tabel
  private function _action_user($id_transaction)
  {
    $link = 
    "<a href='" . base_url('Transaction/delete/' . $id_transaction) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
    </a>";
    return $link;
  }

  // Tombol Opsi Pada Tabel
  private function _action_admin($id_transaction)
  {
    $link = 
    "<a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_transaction . "'>
	    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modaltransaction'><i class='fa fa-edit'></i></button>
	  </a>";
    return $link;
  }

  //Tampilkan show transaksi
  public function show_transaksi($id_transaction)
  {
    $db      = \Config\Database::connect();
    $builder = $db->table('tb_transaction a');
    $builder->select('a.id, a.id_customer, b.customer_name, c.bank_name, c.account_number, a.total, a.status');
    $builder->join('tb_customers b', 'a.id_customer = b.id', 'left');
    $builder->join('tb_account c', 'a.id_acccount = c.id', 'left');
    $builder->where('a.id', $id_transaction);
    $data = $builder->get();
    foreach ($data->getResult() as $row) {
      echo json_encode($row);
    }
  }

  // Simpan data setor di User
  public function create()
  {
    $id_customer  = $this->request->getPost('id_customer');
    $id_acccount  = $this->request->getPost('id_acccount');
    $total        = str_replace('.', '', trim($this->request->getPost('total')));
    $data_validasi = [
          'id_acccount' => $id_acccount,
          'total'       => $total,
    ];
    //Cek Validasi Data Sampah, Jika Data Tidak Valid 
    if ($this->form_validation->run($data_validasi, 'transaction_user') == FALSE) {
      $validasi = [
        'error'     => true,
        'transaction_error' => $this->form_validation->getErrors()
      ];
      echo json_encode($validasi);
    } else {
      $data = [
        'id_customer'       => $id_customer,
        'id_acccount'       => $id_acccount,
        'total'             => $total,
        'date_verification' => '-',
      ];
      $this->UserTransactionModel->save($data);
      $validasi = [
        'success' => true
      ];
        echo json_encode($validasi);
    }
  }

  // Update data setor di Admin
  public function update()
  {
    $id            = $this->request->getPost('id_transaction');
    $status        = $this->request->getPost('status');
    $id_customer   = $this->request->getPost('id_customer');
    $data_customer = $this->ModelCustomer->find($id_customer);
    $total         = str_replace('.', '', trim($this->request->getPost('total')));
    $balance       = $data_customer['balance'] - $total;
    $data_validasi = [
      'status' => $status
    ];

    //Cek Validasi data transaction, Jika Data Tidak Valid 
    if ($this->form_validation->run($data_validasi, 'transaction_admin') == FALSE) {
      $validasi = [
        'error'             => true,
        'transaction_error' => $this->form_validation->getErrors()
      ];
      echo json_encode($validasi);
    } else {
      if ($status != 'Berhasil') {
        $data_transaction = [
          'date_verification' => trim(date('d-m-Y')),
          'status'            => $status
        ];
        $this->AdminTransactionModel->update($id, $data_transaction);
        $validasi = [
          'success' => true
        ];
        echo json_encode($validasi);
      } else {
        $data_customer = [
          'balance' => $balance
        ];
        $this->ModelCustomer->update($id_customer, $data_customer);
        $data_transaction = [
          'date_verification' => trim(date('d-m-Y')),
          'status'            => $status
        ];
        $this->AdminTransactionModel->update($id, $data_transaction);
        $validasi = [
          'success' => true
        ];
        echo json_encode($validasi);
      }
    }
  }

  // Hapus data sampah
  public function delete($id_transaction)
  {
    $this->UserTransactionModel->delete($id_transaction);
  }

  // Tampilkan data sampah
  public function loadDataAdmin()
    {
      if ($this->request->getMethod(true) == 'POST') {
      $lists  = $this->AdminTransactionModel->get_datatables();
      $data   = [];
      $no     = $this->request->getPost("start");
      foreach ($lists as $list) {
        $no++;
        $row    = [];
        $row[]  = $no;
        $row[]  = date("d-m-Y H:i:s", strtotime($list->datetime));
        $row[]  = $list->customer_name;
        $row[]  = $list->bank_name;
        $row[]  = $list->account_number;
        $row[]  = $list->total;
        $row[]  = $list->date_verification;
        $row[]  = $list->status;
        $row[]  = $this->_action_admin($list->id);
        $data[] = $row;
      }
      $output = [
        "draw"            => $this->request->getPost('draw'),
        "recordsTotal"    => $this->AdminTransactionModel->count_all(),
        "recordsFiltered" => $this->AdminTransactionModel->count_filtered(),
        "data"            => $data
      ];
      echo json_encode($output);
    }
  }

  // Tampilkan data sampah
  public function loadDataUser()
  {
    if ($this->request->getMethod(true) == 'POST') {
      $lists = $this->UserTransactionModel->get_datatables();      
      $data = [];
      $no = $this->request->getPost("start");
      foreach ($lists as $list) {
        $no++;
        $row    = [];
        $row[]  = $no;
        $row[]  = date("d-m-Y H:i:s", strtotime($list->datetime));
        $row[]  = $list->bank_name;
        $row[]  = $list->account_number;
        $row[]  = $list->total;
        $row[]  = $list->date_verification;
        $row[]  = $list->status;
        $row[]  = $this->_action_user($list->id);
        $data[] = $row;
      }
      $output = [
        "draw"            => $this->request->getPost('draw'),
        "recordsTotal"    => $this->UserTransactionModel->count_all(),
        "recordsFiltered" => $this->UserTransactionModel->count_filtered(),
        "data"            => $data
      ];
      echo json_encode($output);
    }
  }
}
