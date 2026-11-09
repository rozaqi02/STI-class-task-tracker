<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Kelas 10A',
                'teacher_id' => 1,
            ],
            [
                'name'       => 'Kelas 10B',
                'teacher_id' => 1,
            ],
        ];

        $this->db->table('classes')->insertBatch($data);
    }
}