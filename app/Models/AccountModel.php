<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class AccountModel extends Model
{
  protected $table = "tb_account";
  protected $primaryKey = 'id';
  protected $allowedFields = ['id_customer', 'bank_name', 'account_number', 'the_name_of'];
  protected $column_order = [null, 'id_customer', 'bank_name', 'account_number', 'the_name_of', null];
  protected $column_search = ['id_customer', 'bank_name', 'account_number', 'the_name_of'];
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
    $this->dt      = $this->db->table($this->table)->select('tb_account.id, tb_customers.customer_name, bank_name, account_number, the_name_of')
    ->join('tb_customers', 'tb_customers.id = tb_account.id_customer', 'left')
    ->where('id_customer', $id_customer);
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
