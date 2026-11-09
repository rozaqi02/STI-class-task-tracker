# STI Class Task Tracker

Aplikasi manajemen tugas kelas untuk SchoolTech Indonesia. Guru membuat tugas, siswa melihat dan menandai tugas selesai.

Stack: CodeIgniter 4, React + Vite, MySQL.

## Menjalankan

Buat database:

```sql
CREATE DATABASE sti_task_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

Backend:

```bash
cd backend
composer install
copy .env.example .env
php spark migrate
php spark db:seed UserSeeder
php spark db:seed ClassSeeder
php spark serve
```

Di Linux atau macOS, ganti `copy` dengan `cp`. Sesuaikan user dan password MySQL di `.env` bila perlu. Backend berjalan di `http://localhost:8080`.

Frontend:

```bash
cd frontend
npm install
npm run dev
```

Frontend berjalan di `http://localhost:5173`.

## Akun contoh

| Peran | Email | Password |
| --- | --- | --- |
| Guru | guru@schooltech.id | password123 |
| Siswa | siswa@schooltech.id | password123 |

## Endpoint

| Method | Endpoint | Keterangan | Akses |
| --- | --- | --- | --- |
| POST | /api/auth/register | Registrasi | Publik |
| POST | /api/auth/login | Login | Publik |
| GET | /api/tasks | Daftar tugas, query `search`, `status`, `page` | Login |
| POST | /api/tasks | Buat tugas | Guru |
| PUT | /api/tasks/{id} | Ubah tugas | Guru |
| DELETE | /api/tasks/{id} | Hapus tugas | Guru |
| POST | /api/tasks/{id}/complete | Tandai selesai | Siswa |

## Keputusan dan yang belum selesai

Password di-hash dengan `password_hash`. Status selesai disimpan di tabel `task_completions`. Pencarian, filter, dan pagination ada di API. Di layar, peran hanya mengatur tombol yang tampil. Proteksi peran di backend belum memakai middleware. Tombol halaman, unit test, Docker, dokumentasi Postman, dan notifikasi tenggat belum dibuat.

Alat AI saya pakai sebatas merapikan styling CSS dan sedikit penyesuaian tampilan. Cakupannya tidak banyak. Autentikasi, CRUD tugas, migrasi database, dan halaman React saya kerjakan sendiri.
