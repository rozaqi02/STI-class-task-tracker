<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'due_date', 'class_id', 'created_by', 'created_at'];
    protected $useTimestamps = false;
}