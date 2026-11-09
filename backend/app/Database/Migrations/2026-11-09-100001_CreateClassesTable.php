<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClassesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'teacher_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('teacher_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('classes');
    }

    public function down()
    {
        $this->forge->dropTable('classes');
    }
}