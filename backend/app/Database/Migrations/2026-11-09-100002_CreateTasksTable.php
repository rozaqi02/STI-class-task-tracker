<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTasksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'due_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'class_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('class_id', 'classes', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tasks');
    }

    public function down()
    {
        $this->forge->dropTable('tasks');
    }
}