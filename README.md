# Kanban Board Project 📋

> Sistem Manajemen Tugas Berbasis Papan Kanban Visual & Daftar Tugas Terstruktur menggunakan Laravel & Blade.

---

## ✨ Fitur Aplikasi

- **Kanban Board 4 Kolom**:
  - `Not Started` (Belum Dikerjakan)
  - `In Progress` (Sedang Dikerjakan)
  - `Waiting / In Review` (Menunggu Review)
  - `Completed` (Selesai)
- **Task List View**:
  - Ringkasan daftar tugas dengan sorting tenggat waktu (*due date*).
  - Indikator status berwarna & aksi cepat Edit / Hapus.
- **Form CRUD Tugas Lengkap**:
  - Tambah tugas baru (`POST /tasks`).
  - Edit & perbarui data tugas (`PUT /tasks/{id}`).
  - Validasi input nama, detail, due date, dan status.
  - Hapus tugas secara aman (`DELETE /tasks/{id}`).

---

## 🛠️ Tech Stack

- **Framework**: Laravel 10 / PHP 8.1+
- **Template Engine**: Blade
- **Styling**: Custom Modern CSS + Material Icons
- **Database**: MySQL / SQLite

---

## 🚀 Panduan Menjalankan di Lokal

```bash
# 1. Clone repository
git clone https://github.com/josapratama/kanban-project.git
cd kanban-project

# 2. Install dependencies PHP
composer install

# 3. Salin environment & generate app key
copy .env.example .env
php artisan key:generate

# 4. Jalankan migrasi database
php artisan migrate

# 5. Jalankan development server
php artisan serve
```
Akses aplikasi melalui peramban di: `http://127.0.0.1:8000`
