<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class AdminRubbishModel extends Model
{
  protected $table          = "tb_rubbish_deposit";
  protected $primaryKey     = 'id';
  protected $allowedFields  = ['datetime', 'id_customer', 'id_rubbish', 'total_deposit', 'total', 'date_delivery', 'status'];
  protected $column_order   = [null, 'datetime', 'id_customer', 'id_rubbish', 'total_deposit', 'total', 'date_delivery', 'status', null];
  protected $column_search  = ['datetime', 'customer_name', 'rubbish_name', 'total_deposit', 'total', 'date_delivery', 'status'];
  protected $order = ['id' => 'desc'];
  protected $request;
  protected $db;
  protected $dt;

  function __construct(RequestInterface $request)
  {
    parent::__construct();
    $this->db       = db_connect();
    $this->request  = $request;
    $this->dt       = $this->db->table($this->table);
    $this->dt       = $this->db->table($this->table)->select('tb_rubbish_deposit.id, datetime, tb_customers.customer_name, tb_customers.phone, tb_rubbish.rubbish_name, total_deposit, tb_rubbish_unit.unit_name, total, tb_customers.address, date_delivery, status')
    ->join('tb_customers', 'tb_customers.id = tb_rubbish_deposit.id_customer', 'left')
    ->join('tb_rubbish', 'tb_rubbish.id = tb_rubbish_deposit.id_rubbish', 'left')
    ->join('tb_rubbish_unit', 'tb_rubbish_unit.id = tb_rubbish.id_unit', 'left');
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
