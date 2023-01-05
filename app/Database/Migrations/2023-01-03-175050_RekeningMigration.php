<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RekeningMigration extends Migration
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
            'id_customer'      => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'bank_name'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'account_number'      => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'the_name_of'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_customer', 'customer', 'id');
        $this->forge->createTable('tb_account', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_account');
    }
}
