<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddingTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_firstname'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_lastname'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_email'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_password'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'default'    => null
            ],
           
        ]);
        $this->forge->addKey('user_id', true)
                    ->addUniqueKey('user_email');

        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
