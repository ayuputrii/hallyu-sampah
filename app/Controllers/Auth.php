<?php

namespace App\Controllers;

use Config\Services;
use App\Models\UserModel;
use App\Models\CustomerModel;

class Auth extends BaseController
{
  protected $request;
  protected $form_validation;
  protected $session;
  protected $User;
  protected $Customer;

  public function __construct()
  {
      $this->request         = Services::request();
      $this->form_validation = \Config\Services::validation();
      $this->session         = \Config\Services::session();
      $this->User            = new UserModel($this->request);
      $this->Customer        = new CustomerModel($this->request);
  }

  //Register user
  public function register()
  {
    $data['title']   = "Register | Hallyu Sampah!";
    return view('Users/register', $data);
  }

  // Cek Register
  public function create()
  {
    $customer_name    = $this->request->getPost('customer_name');
    $username         = $this->request->getPost('username');
    $password         = $this->request->getPost('password');

    $data_validasi = [
      'customer_name'  => $customer_name,
      'username'       => $username,
      'password'       => $password,
    ];

    //Cek Validasi Data User, Jika Data Tidak Valid 
    if ($this->form_validation->run($data_validasi, 'register') == FALSE) {
      $validasi = [
          'error'   => true,
          'register_error' => $this->form_validation->getErrors(),
          'link' => base_url('user/register')
        ];
      echo json_encode($validasi);
    } else {
        $data = [
          'customer_name' => $customer_name,
          'username'      => $username,
          'password'      => password_hash($password, PASSWORD_DEFAULT)
        ];
        $this->Customer->save($data);
        $validasi = [
          'success' => true,
          'link'    => base_url('user/dashboard')
        ];
      return redirect('user/dashboard', $validasi);
    }
  }

  // Login Admin
  public function admin()
  {
    $data['title'] = "Login - Admin | Hallyu Sampah!";
    return view('Admin/index', $data);
  }

  // Cek Login Admin
  public function cek_admin_login()
  {
     $username = $this->request->getPost('username');
     $password = $this->request->getPost('password');

     $cek_validasi = [
        'username' => $username,
        'password' => $password
     ];

     if ($this->form_validation->run($cek_validasi, 'login') == FALSE) {
      $validasi = [
        'error'       => true,
        'login_error' => $this->form_validation->getErrors()
      ];
      echo json_encode($validasi);
     }
     else {
      $cekUser = $this->User->where('username', $username)->first();
         // Jika user ada
         if ($cekUser) {
             $password_hash = $cekUser['password'];
             //Cek password, jika password benar
             if (password_verify($password, $password_hash)) {
                 $newdata = [
                    'id'         => $cekUser['id'],
                    'user_name'  => $cekUser['user_name'],
                    'username'   => $cekUser['username'],
                    'level'      => $cekUser['level'],
                    'photo'      => $cekUser['photo'],
                    'logged_in'  => TRUE
                 ];
                 $this->session->set($newdata);
                 $validasi = [
                    'success'   => true,
                    'link'      => base_url('admin/dashboard')
                 ];
                //  echo json_encode($validasi);
                 return redirect('admin/dashboard', $validasi);
             } else {
                $validasi = [
                    'error'       => true,
                    'login_error' => [
                      'password'  => 'Password Salah!'
                    ]
                 ];
                echo json_encode($validasi);
             }
         } else {
             $validasi = [
                'error'       => true,
                'login_error' => [
                  'username' => 'Username Tidak Terdaftar!'
                ]
             ];
             echo json_encode($validasi);
          }
      }
  }

  // Logout Admin
  public function admin_logout()
  {
    $this->session->destroy();
    return redirect()->to('/admin');
  }

  // Login User
  public function user()
  {
    $data['title'] = "Login | Hallyu Sampah!";
    return view('Users/index', $data);
  }

  // Cek Login User
  public function cek_user_login()
  {
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $cek_validasi = [
      'username' => $username,
      'password' => $password
    ];

    //Cek Validasi, Jika Data Tidak Valid 
    if ($this->form_validation->run($cek_validasi, 'login') == FALSE) {
        $validasi = [
          'error'   => true,
          'login_error' => $this->form_validation->getErrors()
        ];               
        echo json_encode($validasi);
    } else {
      // Cek Data Customer berdasarkan username
        $cekUser = $this->Customer->where('username', $username)->first();
      // Jika user ada
        if ($cekUser) {
            $password_hash = $cekUser['password'];
            //Cek password, jika password benar
            if (password_verify($password, $password_hash)) {
                $newdata = [
                    'id'               => $cekUser['id'],
                    'customer_name'    => $cekUser['customer_name'],
                    'username'         => $cekUser['username'],
                    'address'          => $cekUser['address'],
                    'phone'            => $cekUser['phone'],
                    'balance'          => $cekUser['balance'],
                    'photo'            => $cekUser['photo'],
                    'logged_in'        => TRUE
                ];
                $this->session->set($newdata);
                $validasi = [
                    'success'   => true,
                    'link'      => base_url('user/dashboard')
                ];
                return redirect('user/dashboard', $validasi);
            } else {
                $validasi = [
                    'error'       => true,
                    'login_error' => [
                        'password' => 'Password Salah!'
                    ]
                ];
                echo json_encode($validasi);
            }
        } else {
            $validasi = [
                'error'       => true,
                'login_error' => [
                    'username' => 'Username Tidak Terdaftar!'
                ]
            ];
            echo json_encode($validasi);
        }
    }
  }

  // Logout User
  public function user_logout()
  {
    $this->session->destroy();
    return redirect()->to('/user');
  }
}
