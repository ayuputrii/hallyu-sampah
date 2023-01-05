<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NasabahMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'customer_name'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'username'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password'      => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'address'      => [
                'type'       => 'TEXT',
            ],
            'phone'      => [
                'type'       => 'VARCHAR',
                'constraint' => 13,
            ],
            'balance'      => [
                'type'       => 'INT',
            ],
            'photo'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('tb_customers', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_customers');
    }
}