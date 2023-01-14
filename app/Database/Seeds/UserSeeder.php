<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user_data = [
            [
                'user_name' => 'Admin',
                'username'  => 'admin',
                'password'  => password_hash('admin', PASSWORD_DEFAULT),
                'level'     => 'Admin',
            ],
            [
                'user_name' => 'Staff',
                'username'  => 'staff',
                'password'  => password_hash('staff', PASSWORD_DEFAULT),
                'level'     => 'Staff',
            ],
            [
                'user_name' => 'Ayu Armadani',
                'username'  => 'ayuarmadani',
                'password'  => password_hash('12345678', PASSWORD_DEFAULT),
                'level'     => 'User',
            ],
        ];

        foreach ($user_data as $data) {
            $this->db->table('tb_users')->insert($data);
        }
    }
}
