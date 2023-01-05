<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SetorSampahMigration extends Migration
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
            'id_rubbish'      => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'total_deposit'      => [
                'type' => 'INT',
            ],
            'total'      => [
                'type' => 'INT',
            ],
            'date_delivery'      => [
                'type'       => 'DATE',
            ],
            'status'      => [
                'type'       => 'ENUM',
                'constraint' => ['Waiting', 'Successfully', 'Failed'],
                'default'    => 'Waiting',
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_customer', 'customer', 'id');
        $this->forge->addForeignKey('id_rubbish', 'rubbish', 'id');
        $this->forge->createTable('tb_rubbish_deposit', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_rubbish_deposit');
    }
}