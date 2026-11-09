<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaskCompletionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'task_id' => [
                'type' => 'INT',
            ],
            'student_id' => [
                'type' => 'INT',
            ],
            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('task_id', 'tasks', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('student_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('task_completions');
    }

    public function down()
    {
        $this->forge->dropTable('task_completions');
    }
}