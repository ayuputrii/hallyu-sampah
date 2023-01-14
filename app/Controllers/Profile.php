<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use App\Models\UserModel;
use App\Models\CustomerModel;

class Profile extends BaseController
{
	protected $session;
	protected $request;
    protected $User;
    protected $Customer;
    protected $form_validation;

	public function __construct()
	{
        $this->request   = Services::request();
        $this->User      = new UserModel($this->request);
        $this->Customer  = new CustomerModel($this->request);
        $this->form_validation  = \Config\Services::validation();
		$this->session   = \Config\Services::session();
	}

	// Halaman Dashboard Admin
	public function admin()
	{
		$data['title']	    = "Profile - Admin | Hallyu Sampah!";
		$data['menu']	  	= "";
		$data['page']	  	= "profil";
        $data['id']         = $this->session->get('id');
		$data['user_name'] 	= $this->session->get('user_name');
		$data['level']	    = $this->session->get('level');
		$data['photo']	  	= $this->session->get('photo');
		return view('Admin/profil', $data);
	}

	// Halaman Dashboard User
	public function user()
	{
		$data['title']	 		= "Profile | Hallyu Sampah!";
		$data['menu']	  	    = "";
		$data['page']	  		= "profil";
		$data['id']           	= $this->session->get('id');
		$data['customer_name'] 	= $this->session->get('customer_name');
		$data['balance']        = $this->session->get('balance');
		$data['photo']         	= $this->session->get('photo');
		return view('Users/profil', $data);
	}

    public function show($id_user)
    {
        $data = $this->User->find($id_user);
        echo json_encode($data);
    }

    public function show_user($id_customer)
    {
        $data = $this->Customer->find($id_customer);
        echo json_encode($data);
    }

	// Update data Admin
	public function update_profile_admin()
	{
		$id            = $this->request->getPost('id_user');
		$user_name     = $this->request->getPost('user_name');
		$username      = $this->request->getPost('username');
		$password      = $this->request->getPost('password');
		$level         = $this->request->getPost('level');
		$photo         = $this->request->getFile('photo');
 
		//data user
		$data_validasi = [
			'user_name' => $user_name,
			'username'  => $username,
			'level'     => $level,
			'photo'     => $photo
		];
 
		//Cek Validasi data user, Jika Data Tidak Valid 
		if ($this->form_validation->run($data_validasi, 'profile_admin') == FALSE) {
			$validasi = [
				'error'   	 => true,
				'user_error' => $this->form_validation->getErrors()
			];
			echo json_encode($validasi);
		} else {
			if ($photo == '' && $password == '') {
				//data user
				$data = [
					'user_name'     => $user_name,
					'username'      => $username,
					'level'         => $level
				];
				//Update data user
				$this->User->update($id, $data);
 
				$validasi = [
					'success'   => true
				];
				echo json_encode($validasi);
			} else if ($photo != '' && $password == '') {
				//Pindahkan file photo peserta ke direktori public/user
				$photo_name = $photo->getRandomName();
				$photo->move('images/user', $photo_name);
				//data user
				$data = [
					'user_name'     => $user_name,
					'username'      => $username,
					'level'         => $level,
					'photo'         => $photo_name
				];
				// hapus photo lama
				$old_photo = $this->User->find($id);
				if ($old_photo['photo'] == true) {
					unlink('images/user/' . $old_photo['photo']);
				}
				//Update data user
				$this->User->update($id, $data);
 
				$validasi = [
					'success'   => true
				];
				echo json_encode($validasi);
			} else if ($photo == '' && $password != '') {
				//data user
				$data = [
					'user_name'     => $user_name,
					'username'      => $username,
					'password'      => password_hash($password, PASSWORD_DEFAULT),
					'level'         => $level
				];
				//Update data user
				$this->User->update($id, $data);
 
				$validasi = [
					'success'   => true
				];
				echo json_encode($validasi);
			} else {
				//Pindahkan file photo peserta ke direktori public/user
				$photo_name = $photo->getRandomName();
				$photo->move('images/user', $photo_name);
				//data user
				$data = [
					'user_name'     => $user_name,
					'username'      => $username,
					'password'      => password_hash($password, PASSWORD_DEFAULT),
					'level'         => $level,
					'photo'         => $photo_name
				];
				// hapus photo lama
				$old_photo = $this->User->find($id);
				if ($old_photo['photo'] == true) {
					unlink('images/user/' . $old_photo['photo']);
				}
				//Update data user
				$this->User->update($id, $data);
 
				$validasi = [
					'success'   => true
				];
				echo json_encode($validasi);
			}
		}
	}
 
	// Update data User
	public function update_profile_user()
	{
		$id           	= $this->request->getPost('id_customer');
		$customer_name 	= $this->request->getPost('customer_name');
		$username     	= $this->request->getPost('username');
		$password     	= $this->request->getPost('password');
		$address       	= $this->request->getPost('address');
		$phone      	= $this->request->getPost('phone');
		$photo         	= $this->request->getFile('photo');
 
		//data customer
		$data_validasi = [
			'customer_name'   => $customer_name,
			'username'     	  => $username,
			'address'         => $address,
			'phone'      	  => $phone,
			'photo'           => $photo
		];
 
		//Cek Validasi data customer, Jika Data Tidak Valid 
		if ($this->form_validation->run($data_validasi, 'profile_user') == FALSE) {
 
			$validasi = [
				'error'   => true,
				'customer_error' => $this->form_validation->getErrors()
			];
			echo json_encode($validasi);
		}
		//Data Valid
		else {
			if ($photo == '' && $password == '') {
				//data customer
				$data = [
					'customer_name' => $customer_name,
					'username'     	=> $username,
					'address'       => $address,
					'phone'      	=> $phone,
				];
				//Update data customer
				$this->Customer->update($id, $data);
 
				$validasi = [
					'success'   => true
				];
				echo json_encode($validasi);
			} else if ($photo != '' && $password == '') {
				//Pindahkan file photo peserta ke direktori public/customer
				$photo_name = $photo->getRandomName();
				$photo->move('images/customer', $photo_name);
				//data customer
				$data = [
					'customer_name' => $customer_name,
					'username'     	=> $username,
					'address'       => $address,
					'phone'      	=> $phone,
					'photo'         => $photo_name
				];
				// hapus photo lama
				$old_photo = $this->Customer->find($id);
				if ($old_photo['photo'] == true) {
					unlink('images/customer/' . $old_photo['photo']);
				}
				//Update data customer
				$this->Customer->update($id, $data);
 
				$validasi = [
					'success'   => true
				];
				echo json_encode($validasi);
			} else if ($photo == '' && $password != '') {
				//data customer
				$data = [
					'customer_name' => $customer_name,
					'username'     	=> $username,
					'password'     	=> password_hash($password, PASSWORD_DEFAULT),
					'address'       => $address,
					'phone'      	=> $phone,
				];
				//Update data customer
				$this->Customer->update($id, $data);
 
				$validasi = [
					'success'   => true
				];
				echo json_encode($validasi);
			} else {
				//Pindahkan file photo peserta ke direktori public/customer
				$photo_name = $photo->getRandomName();
				$photo->move('images/customer', $photo_name);
				//data customer
				$data = [
					'customer_name' => $customer_name,
					'username'     	=> $username,
					'password'     	=> password_hash($password, PASSWORD_DEFAULT),
					'address'       => $address,
					'phone'      	=> $phone,
					'photo'        	=> $photo_name
				];
				// hapus photo lama
				$old_photo = $this->Customer->find($id);
				if ($old_photo['photo'] == true) {
					unlink('images/customer/' . $old_photo['photo']);
				}
				//Update data customer
				$this->Customer->update($id, $data);
 
				$validasi = [
					'success'   => true
				];
				echo json_encode($validasi);
			}
		}
	}
}