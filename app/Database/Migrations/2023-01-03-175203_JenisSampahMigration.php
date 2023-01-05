<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisSampahMigration extends Migration
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
            'type_name'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('tb_rubbish_type', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_rubbish_type');
    }
}