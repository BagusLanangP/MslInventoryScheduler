# Dokumentasi Perubahan Kode (Changelog) - MSL FinTrack & Scheduler

Dokumen ini mencatat semua perubahan, perbaikan, dan peningkatan fitur yang telah dilakukan pada repositori **MSL FinTrack & Scheduler** sejak pertama kali di-clone hingga saat ini.

---

## 📅 Ringkasan Fitur Utama & Perbaikan

### 1. 📂 Perubahan Skema Database & Migrasi
*   **Role & Telepon User**: Menambahkan kolom `role` (admin/operator/staff) dan `telepon` pada tabel `users`.
*   **Profil Supplier**: Menambahkan kolom `alamat` dan `pic` pada tabel `suppliers` untuk pencatatan kontak yang lebih lengkap.
*   **Tracker Agenda**: Menambahkan kolom `created_by` (untuk mencatat pembuat jadwal) dan `completed_at` (tanggal penyelesaian) pada tabel `schedules`.
*   **Integrasi Inventaris-Agenda**: Menambahkan kolom `inventory_checking_id` pada tabel `schedules` sebagai foreign key untuk sinkronisasi otomatis barang kadaluarsa.

### 2. 🔐 Perbaikan Autentikasi (Authentication Fixes)
*   **Metode Logout**: Mengubah route logout dari `GET` menjadi `POST` yang aman untuk mencegah error *MethodNotAllowedHttpException* ketika tombol logout diklik.
*   **Error Feedback Login**: Memperbaiki validasi login dan menampilkan pesan kesalahan (`$errors`) langsung di form login jika email/password salah dengan outline input berwarna merah.

### 3. 📅 Kalender Interaktif (Calendar View)
*   **FullCalendar 6 Integration**: Menambahkan tab visualisasi Kalender pada dasbor admin dan halaman publik menggunakan FullCalendar dengan kustomisasi tema Emerald.
*   **Drag-and-Drop Rescheduling**: Admin dapat menggeser (drag-and-drop) event pada kalender untuk mengubah tanggal agenda secara langsung. Perubahan ini dikirim melalui AJAX ke backend (`/admin/schedule/{id}/update-date`).
*   **Hari Libur Nasional**: Menghubungkan kalender dengan data hari libur nasional dari API pemerintah (ditandai dengan warna amber/orange dan bersifat read-only).
*   **Public Read-Only**: Halaman kalender publik dinonaktifkan fitur editnya agar pengunjung biasa tidak dapat menggeser agenda.

### 4. ⚠️ Sinkronisasi Otomatis Kadaluarsa Barang (Expiry-to-Schedule Sync)
*   **Otomatisasi Agenda**: Ketika barang baru ditambahkan ke inventaris dengan `expired_date` (tanggal kadaluarsa), sistem secara otomatis membuat agenda pengingat baru di bawah kategori "Kedaluwarsa Barang".
*   **Formula Tanggal**:
    *   **Tanggal Reminder**: Tanggal aktual barang kadaluarsa.
    *   **Tanggal Pelaksanaan**: 30 hari sebelum tanggal kadaluarsa (di-safeguard agar tidak mendahului tanggal barang masuk).
*   **Sinkronisasi Update & Delete**: Jika data barang diubah atau dihapus, agenda terkait akan diperbarui atau dihapus secara otomatis.

### 5. 📊 Dasbor Analitis Keuangan & Anggaran
*   **Metrik Ringkasan (Real-time)**:
    *   **Untung Kotor**: Dihitung dari selisih `harga_jual` dan `harga_pokok` dikali `jumlah` stok inventaris.
    *   **Anggaran Terpakai**: Total budget yang dialokasikan di agenda operasional.
    *   **Sisa Saldo Operasional**: Selisih Untung Kotor dengan Anggaran Terpakai.
*   **Visualisasi Chart.js**:
    *   **Bar Chart**: Tren perbandingan bulanan antara keuntungan kotor dan pengeluaran anggaran.
    *   **Doughnut Chart**: Distribusi alokasi anggaran berdasarkan kategori agenda operasional.

### 6. 🚚 Peningkatan CRUD Supplier & User Management
*   **Perbaikan Binding & Route**: Memperbaiki routing CRUD Supplier yang tidak sinkron dan mengintegrasikan template `createSupplier.blade.php` agar dapat digunakan untuk tambah & edit data sekaligus.
*   **Middleware Super Admin**: Menerapkan `EnsureSuperAdmin` middleware untuk mengunci halaman manajemen pengguna agar hanya dapat diakses oleh akun bersatus 'admin'.

### 7. ✉️ Perbaikan Notifikasi Email (Email Notifier)
*   **Email Dinamis**: Memperbaiki controller notifikasi email agar data barang inventaris yang dikirimkan sesuai dengan ID inventaris (bukan mengambil data schedule acak).

### 8. 🧪 Automated Testing (Unit & Feature Tests)
*   Menambahkan unit dan feature test di direktori `tests/Feature` (`ScheduleManagementTest.php` & `UserManagementTest.php`) untuk memastikan seluruh fungsi kritis berjalan dengan baik. Semua **17 test case** saat ini lulus 100%.

---

## 🛠️ Daftar File yang Mengalami Perubahan

### Backend (Controllers, Models, & Migrations)
*   `app/Http/Controllers/AdminController.php` (Logika kalkulasi finansial & widget dasbor)
*   `app/Http/Controllers/ApiLiburController.php` (Sinkronisasi hari libur)
*   `app/Http/Controllers/AuthController.php` (Penanganan login/logout)
*   `app/Http/Controllers/EmailController.php` (Pengiriman notifikasi email inventaris & schedule)
*   `app/Http/Controllers/InventoryCheckingController.php` (Pemicu sinkronisasi kadaluarsa agenda)
*   `app/Http/Controllers/ScheduleController.php` (Fungsi toggle status & update date via AJAX)
*   `app/Http/Controllers/SupplierController.php` (Fungsi CRUD & toggle status supplier)
*   `app/Http/Controllers/UserController.php` (Fungsi CRUD Manajemen User)
*   `app/Http/Middleware/EnsureSuperAdmin.php` (Middleware otorisasi admin)
*   `app/Models/Schedule.php` (Definisi mass assignment kolom tambahan)
*   `app/Models/Supplier.php` (Casting tanggal kerjasama)
*   `app/Models/User.php` (Konfigurasi User factory)
*   `bootstrap/app.php` (Registrasi alias middleware)
*   `routes/web.php` (Penyusunan route-route baru)

### Database Seeders & Migrations
*   `database/migrations/*` (File penambahan kolom pada tabel user, supplier, schedule, dan foreign key)
*   `database/seeders/ScheduleSeeder.php` (Seeder dummy schedule)
*   `database/seeders/UserSeeder.php` (Seeder akun default admin)

### Frontend (Blade Views)
*   `resources/views/admin/Inventory/index.blade.php` (List inventaris dengan tombol email & status kadaluarsa)
*   `resources/views/admin/Inventory/edit.blade.php` (Form edit barang inventaris dengan hitung otomatis total)
*   `resources/views/admin/Schedule/create.blade.php` (Form buat/edit agenda dengan visual rupiah formatter dan validasi tanggal)
*   `resources/views/admin/Schedule/index.blade.php` (Daftar agenda dengan tab kalender & handler AJAX)
*   `resources/views/admin/Supplier/index.blade.php` (Daftar supplier dan tombol aktif/nonaktif)
*   `resources/views/admin/createSupplier.blade.php` (Form tambah/edit supplier)
*   `resources/views/admin/dashboard.blade.php` (Dasbor finansial dengan integrasi Chart.js)
*   `resources/views/admin/layouts/app.blade.php` (Layout utama admin dengan tombol logout aman)
*   `resources/views/admin/layouts/sidebar.blade.php` (Sidebar menu dengan tautan user management terkunci)
*   `resources/views/auth/login.blade.php` (Form login baru dengan validasi visual)
*   `resources/views/index.blade.php` (Landing page dengan hitung counter supplier/inventaris)
*   `resources/views/layouts/index.blade.php` (Layout landing page publik)
*   `resources/views/schedule/index.blade.php` (Kalender publik versi read-only)
