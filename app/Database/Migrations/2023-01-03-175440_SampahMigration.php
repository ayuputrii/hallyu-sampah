<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SampahMigration extends Migration
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
            'rubbish_name'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'id_type'          => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_unit'          => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'price'      => [
                'type'       => 'INT',
            ],
            'desc'      => [
                'type' => 'TEXT',
            ],
            'stock'      => [
                'type'       => 'INT',
            ],
            'photo'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('id_type', 'type', 'id');
        $this->forge->addForeignKey('id_unit', 'unit', 'id');
        $this->forge->createTable('tb_rubbish', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_rubbish');
    }
}
