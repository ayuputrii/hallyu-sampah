<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $nasabah_data = [
            [
                'customer_name'     => 'Ayu',
                'username'          => 'ayu',
                'password'          => password_hash('12345678', PASSWORD_DEFAULT),
                'address'           => 'Alamat Ayu',
                'phone'             => '081524232323',
            ],
        ];

        foreach ($nasabah_data as $data) {
            $this->db->table('tb_customers')->insert($data);
        }
    }
}
