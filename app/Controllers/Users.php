<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class Users extends BaseController
{
    protected $ModelUser;
    protected $request;
    protected $form_validation;
    protected $session;

    public function __construct()
    {
        $this->request         = Services::request();
        $this->ModelUser       = new UserModel($this->request);
        $this->form_validation = \Config\Services::validation();
        $this->session         = \Config\Services::session();
    }

    public function index()
    {
        $data['title']     = "Data User | Hallyu Sampah!";
        $data['menu']      = "";
        $data['page']      = "user";
        $data['user_name'] = $this->session->get('user_name');
        $data['level']     = $this->session->get('level');
        $data['photo']     = $this->session->get('photo');
        return view('Admin/management-user', $data);
    }

    // Tombol Opsi Pada Tabel
    private function _action($id_user)
    {
        $link = 
            "<a data-toggle='tooltip' data-placement='top' class='btnEdit' title='Edit' value='" . $id_user . "'>
	      	    <button type='button' class='btn btn-primary btn-sm data-toggle='modal' data-target='#modalUser'><i class='fa fa-edit'></i></button>
	      	</a>
            <a href='" . base_url('Users/delete/' . $id_user) . "' class='btnHapus' data-toggle='tooltip' data-placement='top' title='Hapus'>
	      	    <button type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>
            </a>";
        return $link;
    }

    // Tampilkan data saat edit
    public function show($id_user)
    {
        $data = $this->ModelUser->find($id_user);
        echo json_encode($data);
    }

    // Simpan data user
    public function save()
    {
        $user_name = ucwords($this->request->getPost('user_name'));
        $username  = $this->request->getPost('username');
        $password  = $this->request->getPost('password');
        $level     = $this->request->getPost('level');
        $photo     = $this->request->getFile('photo');

        $data_validasi = [
            'user_name' => $user_name,
            'username'  => $username,
            'password'  => $password,
            'level'     => $level,
            'photo'     => $photo
        ];

        //Cek Validasi Data User, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'add_user') == FALSE) {

            $validasi = [
                'error'   => true,
                'user_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            if ($photo == '') {
                //data user
                $data = [
                    'user_name' => $user_name,
                    'username'  => $username,
                    'password'  => password_hash($password, PASSWORD_DEFAULT),
                    'level'     => $level
                ];
                //Simpan data user
                $this->ModelUser->save($data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file photo ke direktori public/user
                $nama_photo = $photo->getRandomName();
                $photo->move('images/user', $nama_photo);
                //Data User
                $data = [
                    'user_name' => $user_name,
                    'username'  => $username,
                    'password'  => password_hash($password, PASSWORD_DEFAULT),
                    'level'     => $level,
                    'photo'     => $nama_photo
                ];
                //Simpan Data User
                $this->ModelUser->save($data);

                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }            
        }
    }

    // Update data user
    public function update()
    {
        $id        = $this->request->getPost('id_user');
        $user_name = ucwords($this->request->getPost('user_name'));
        $username  = $this->request->getPost('username');
        $password  = $this->request->getPost('password');
        $level     = $this->request->getPost('level');
        $photo     = $this->request->getFile('photo');

        //data user
        $data_validasi = [
            'user_name' => $user_name,
            'username'  => $username,
            'password'  => $password,
            'level'     => $level,
            'photo'     => $photo
        ];

        //Cek Validasi data user, Jika Data Tidak Valid 
        if ($this->form_validation->run($data_validasi, 'update_user') == FALSE) {

            $validasi = [
                'error'   => true,
                'user_error' => $this->form_validation->getErrors()
            ];
            echo json_encode($validasi);
        } else {
            if ($photo == '' && $password == '') {
                $data = [
                    'user_name' => $user_name,
                    'username'  => $username,
                    'level'     => $level
                ];
                $this->ModelUser->update($id, $data);
                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else if ($photo != '' && $password == '') {
                //Pindahkan file photo peserta ke direktori public/user
                $nama_photo = $photo->getRandomName();
                $photo->move('images/user', $nama_photo);
                $data = [
                    'user_name' => $user_name,
                    'username'  => $username,
                    'level'     => $level,
                    'photo'     => $nama_photo
                ];
                // hapus photo lama
                $old_photo = $this->ModelUser->find($id);
                if ($old_photo['photo'] == true) {
                    unlink('images/user/' . $old_photo['photo']);
                }

                $this->ModelUser->update($id, $data);
                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else if ($photo == '' && $password != '') {
                $data = [
                    'user_name' => $user_name,
                    'username'  => $username,
                    'level'     => $level,
                    'password'  => password_hash($password, PASSWORD_DEFAULT)
                ];
                $this->ModelUser->update($id, $data);
                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            } else {
                //Pindahkan file photo peserta ke direktori public/user
                $nama_photo = $photo->getRandomName();
                $photo->move('images/user', $nama_photo);
                //data user
                $data = [
                    'user_name' => $user_name,
                    'username'  => $username,
                    'level'     => $level,
                    'password'  => password_hash($password, PASSWORD_DEFAULT),
                    'photo'     => $nama_photo
                ];
                // hapus photo lama
                $old_photo = $this->ModelUser->find($id);
                if ($old_photo['photo'] == true) {
                    unlink('images/user/' . $old_photo['photo']);
                }
                //Update data user
                $this->ModelUser->update($id, $data);
                $validasi = [
                    'success'   => true
                ];
                echo json_encode($validasi);
            }
        }
    }

    // Hapus data user
    public function delete($id_user)
    {
        $data = $this->ModelUser->find($id_user);
        // delete photo
        if ($data['photo'] == true) {
            unlink('images/user/' . $data['photo']);
        }
        $this->ModelUser->delete($id_user);
    }

    // Tampilkan data user
    public function loadData()
    {
        if ($this->request->getMethod(true) == 'POST') {
            $lists = $this->ModelUser->get_datatables();
            $data  = [];
            $no    = $this->request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row    = [];
                $row[]  = $no;
                $row[]  = $list->photo;
                $row[]  = $list->user_name;
                $row[]  = $list->username;
                $row[]  = $list->level;
                $row[]  = $this->_action($list->id);
                $data[] = $row;
            }
            $output = [
                "draw"            => $this->request->getPost('draw'),
                "recordsTotal"    => $this->ModelUser->count_all(),
                "recordsFiltered" => $this->ModelUser->count_filtered(),
                "data"            => $data
            ];
            echo json_encode($output);
        }
    }
}
