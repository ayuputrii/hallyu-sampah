<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserTransactionModel extends Model
{
  protected $table = "tb_transaction";
  protected $primaryKey = 'id';
  protected $allowedFields = ['datetime', 'id_customer', 'id_account', 'total', 'date_verification', 'status'];
  protected $column_order = [null, 'datetime', 'id_customer', 'id_account', 'total', 'date_verification', 'status', null];
  protected $column_search = ['datetime', 'id_customer', 'id_account', 'total', 'date_verification', 'status'];
  protected $order = ['id' => 'desc'];
  protected $request;
  protected $db;
  protected $dt;
  protected $session;

  function __construct(RequestInterface $request)
  {
    parent::__construct();
    $this->db      = db_connect();
    $this->request = $request;
    $this->session = \Config\Services::session();
    $id_customer   = $this->session->get('id');
    $this->dt      = $this->db->table($this->table);
    $this->dt      = $this->db->table($this->table)->select('tb_transaction.id, datetime, tb_customers.customer_name, tb_account.bank_name, tb_account.account_number, total, date_verification, status')
    ->join('tb_customers', 'tb_customers.id = tb_transaction.id_customer', 'left')
    ->join('tb_account', 'tb_account.id = tb_transaction.id_account', 'left')
    ->where('tb_transaction.id_customer', $id_customer);
  }

  private function _get_datatables_query()
  {
    $i = 0;
    foreach ($this->column_search as $item) {
      if ($this->request->getPost('search')['value']) {
        if ($i === 0) {
          $this->dt->groupStart();
          $this->dt->like($item, $this->request->getPost('search')['value']);
        } else {
          $this->dt->orLike($item, $this->request->getPost('search')['value']);
        }
        if (count($this->column_search) - 1 == $i)
        $this->dt->groupEnd();  
      }
      $i++;
    }

    if ($this->request->getPost('order')) {
      $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->dt->orderBy(key($order), $order[key($order)]);
    }
  }

  function get_datatables()
  {
    $this->_get_datatables_query();
    if ($this->request->getPost('length') != -1)
    $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    $query = $this->dt->get();
    return $query->getResult();
  }

  function count_filtered()
  {
    $this->_get_datatables_query();
    return $this->dt->countAllResults();
  }

  public function count_all()
  {
    $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
  }
}