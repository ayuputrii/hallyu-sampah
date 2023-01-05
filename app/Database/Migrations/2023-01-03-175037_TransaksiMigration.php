<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiMigration extends Migration
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
            'datetime DATETIME DEFAULT CURRENT_TIMESTAMP',
            'id_customer'      => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_account'      => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'total'      => [
                'type' => 'INT',
            ],
            'date_verification'      => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'status'      => [
                'type'       => 'ENUM',
                'constraint' => ['Waiting', 'Successfully', 'Failed'],
                'default'    => 'Waiting',
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_customer', 'customer', 'id');
        $this->forge->addForeignKey('id_account', 'account', 'id');
        $this->forge->createTable('tb_transaction', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_transaction');
    }
}