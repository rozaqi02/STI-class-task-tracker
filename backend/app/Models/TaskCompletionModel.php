<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskCompletionModel extends Model
{
    protected $table = 'task_completions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['task_id', 'student_id', 'completed_at'];
    protected $useTimestamps = false;
}