<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\TaskModel;
use App\Models\TaskCompletionModel;
use CodeIgniter\API\ResponseTrait;

class TaskController extends BaseController
{
    use ResponseTrait;

// GET /api/tasks
public function index()
{
    $taskModel = new TaskModel();
    $completionModel = new TaskCompletionModel();

    $search   = $this->request->getGet('search');
    $status   = $this->request->getGet('status');   // completed atau pending
    $page     = (int) ($this->request->getGet('page') ?? 1);
    $perPage  = (int) ($this->request->getGet('per_page') ?? 10);

    $builder = $taskModel->builder();

    // Search berdasarkan judul
    if ($search) {
        $builder->like('title', $search);
    }

    // Ambil semua tugas dulu
    $tasks = $builder->get()->getResultArray();

    // Tambahkan status selesai / belum
    foreach ($tasks as &$task) {
        $completed = $completionModel
            ->where('task_id', $task['id'])
            ->first();

        $task['is_completed'] = $completed ? true : false;
    }

    // Filter berdasarkan status
    if ($status === 'completed') {
        $tasks = array_filter($tasks, fn($t) => $t['is_completed'] === true);
    } elseif ($status === 'pending') {
        $tasks = array_filter($tasks, fn($t) => $t['is_completed'] === false);
    }

    // Reset index array
    $tasks = array_values($tasks);

    // Pagination manual
    $total = count($tasks);
    $offset = ($page - 1) * $perPage;
    $paginated = array_slice($tasks, $offset, $perPage);

    return $this->respond([
        'status' => true,
        'data'   => $paginated,
        'meta'   => [
            'current_page' => $page,
            'per_page'     => $perPage,
            'total'        => $total,
            'last_page'    => ceil($total / $perPage),
        ]
    ]);
}

    // POST /api/tasks (Guru)
    public function create()
    {
        $rules = [
            'title'       => 'required',
            'description' => 'required',
            'due_date'    => 'required',
            'class_id'    => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $taskModel = new TaskModel();

        $data = [
            'title'       => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
            'due_date'    => $this->request->getVar('due_date'),
            'class_id'    => $this->request->getVar('class_id'),
            'created_by'  => 1, // sementara hardcode, nanti diganti dari token
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $taskModel->insert($data);

        return $this->respondCreated([
            'status'  => true,
            'message' => 'Tugas berhasil dibuat'
        ]);
    }

    // PUT /api/tasks/{id} (Guru)
    public function update($id = null)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->find($id);

        if (!$task) {
            return $this->failNotFound('Tugas tidak ditemukan');
        }

        $data = [
            'title'       => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
            'due_date'    => $this->request->getVar('due_date'),
        ];

        $taskModel->update($id, $data);

        return $this->respond([
            'status'  => true,
            'message' => 'Tugas berhasil diupdate'
        ]);
    }

    // DELETE /api/tasks/{id} (Guru)
    public function delete($id = null)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->find($id);

        if (!$task) {
            return $this->failNotFound('Tugas tidak ditemukan');
        }

        $taskModel->delete($id);

        return $this->respondDeleted([
            'status'  => true,
            'message' => 'Tugas berhasil dihapus'
        ]);
    }

    // POST /api/tasks/{id}/complete (Siswa)
    public function complete($id = null)
    {
        $completionModel = new TaskCompletionModel();

        $data = [
            'task_id'      => $id,
            'student_id'   => 2, // sementara hardcode
            'completed_at' => date('Y-m-d H:i:s'),
        ];

        $completionModel->insert($data);

        return $this->respond([
            'status'  => true,
            'message' => 'Tugas berhasil ditandai selesai'
        ]);
    }
}