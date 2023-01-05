<?php

namespace App\Controllers;

use Config\Services;

class Dashboard extends BaseController
{
	protected $session;
	protected $request;

	public function __construct()
	{
		$this->request = Services::request();
		$this->session = \Config\Services::session();
	}

	// Halaman Dashboard Admin
	public function admin()
	{
		$data['title']	 		= "Dashboard - Admin | Hallyu Sampah!";
		$data['menu']	  		= "";
		$data['page']	  		= "dashboard";
		$data['user_name'] 	= $this->session->get('user_name');
		$data['level']	 		= $this->session->get('level');
		$data['photo']	  	= $this->session->get('photo');
		return view('Admin/dashboard', $data);
	}

	// Halaman Dashboard User
	public function user()
	{
		$data['title']	 				= "Dashboard | Hallyu Sampah!";
		$data['menu']	  				= "";
		$data['page']	  				= "dashboard";
		$data['id']           	= $this->session->get('id');
		$data['customer_name'] 	= $this->session->get('customer_name');
		$data['balance']        = $this->session->get('balance');
		$data['photo']         	= $this->session->get('photo');
		return view('Users/dashboard', $data);
	}
}
?>