<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserMigration extends Migration
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
            'user_name'      => [
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
            'level'      => [
                'type'       => 'ENUM',
                'constraint' => ['Admin','Staff','Partner','User'],
            ],
            'photo'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('tb_users', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tb_users');
    }
}
