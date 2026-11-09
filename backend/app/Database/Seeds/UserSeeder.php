<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Guru Demo',
                'email' => 'guru@schooltech.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'guru',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Siswa Demo',
                'email' => 'siswa@schooltech.id',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'siswa',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}