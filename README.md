# SIKALEM - Sistem Kalibrasi Lembar Kerja

Aplikasi web untuk manajemen dan evaluasi kinerja instansi pemerintah daerah berbasis Laravel.

## Tentang SIKALEM

SIKALEM (Sistem Kalibrasi Lembar Kerja) adalah aplikasi berbasis web yang digunakan untuk mengelola evaluasi kinerja instansi pemerintah. Sistem ini memungkinkan admin untuk mengelola data instansi, variabel evaluasi, dan user, sementara user dapat melakukan input dan submit lembar kerja evaluasi untuk instansi yang di-mapping ke akun mereka.

## Fitur Utama

-   **Manajemen User**: Admin dapat mengelola user dan mapping user ke instansi
-   **Manajemen Instansi**: CRUD data instansi pemerintah
-   **Lembar Kerja Evaluasi**: Input, edit, dan submit evaluasi kinerja
-   **Workflow Approval**: Submit, approve, dan reject lembar kerja
-   **Upload Dokumen**: Upload bukti dokumen untuk setiap variabel evaluasi
-   **Role-based Access**: Pemisahan akses antara Admin dan User
-   **Dashboard**: Statistik dan ringkasan data untuk Admin dan User
-   **Profile Management**: User dapat mengubah nama dan password

## Tech Stack

-   **Framework**: Laravel 12.0
-   **PHP**: 8.2+
-   **Database**: MySQL
-   **CSS Framework**: Tailwind CSS 4.0
-   **JavaScript**: jQuery 3.7.1, Alpine.js
-   **Icons**: Font Awesome 6.5.1
-   **Build Tool**: Vite

## Requirements

Pastikan sistem Anda memiliki:

-   PHP >= 8.2
-   Composer
-   Node.js >= 18.x
-   NPM atau Yarn
-   MySQL >= 8.0
-   Git

## Instalasi

### 1. Clone Repository

```bash
extract sikalem.zip
cd sikalem
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Install Dependencies JavaScript

```bash
npm install
```

### 4. Konfigurasi Environment

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sikalem_db
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Buat Database

Buat database baru di MySQL:

```sql
CREATE DATABASE sikalem_db;
```

### 7. Jalankan Migration

```bash
php artisan migrate
```

### 8. Jalankan Seeder

Seeder akan membuat:

-   40 data instansi
-   Variabel dan tingkat evaluasi
-   1 user admin

```bash
php artisan db:seed
```

### 9. Buat Storage Link

```bash
php artisan storage:link
```

### 10. Build Assets

```bash
npm run build
```

Untuk development (dengan hot reload):

```bash
npm run dev
```

## Menjalankan Aplikasi

### Development Mode

Jalankan 2 terminal secara bersamaan:

**Terminal 1 - Laravel Server:**

```bash
php artisan serve
```

**Terminal 2 - Vite Dev Server:**

```bash
npm run dev
```

Aplikasi akan berjalan di: `http://localhost:8000`

### Production Mode

Build assets terlebih dahulu:

```bash
npm run build
```

Jalankan server:

```bash
php artisan serve
```

## Default Credentials

Setelah menjalankan seeder, gunakan kredensial berikut untuk login sebagai admin:

```
Email: admin@sikalem.go.id
Password: password
```

**PENTING**: Segera ganti password setelah login pertama kali!

## Struktur User Role

### Admin

-   Akses penuh ke semua fitur
-   Dapat mengelola instansi, user, dan variabel
-   Dapat melihat semua lembar kerja
-   Dapat approve/reject lembar kerja
-   Tidak di-mapping ke instansi tertentu

### User (Evaluator)

-   Di-mapping ke instansi tertentu
-   Dapat membuat dan mengelola lembar kerja untuk instansi yang di-mapping
-   Hanya dapat melihat lembar kerja sendiri
-   Dapat submit lembar kerja untuk review admin

## Workflow Lembar Kerja

1. **Draft**: User membuat lembar kerja baru
2. **Edit**: User mengisi data evaluasi dan upload dokumen
3. **Submit**: User submit lembar kerja ke admin
4. **Review**: Admin review dan approve/reject
5. **Approved**: Lembar kerja disetujui
6. **Rejected**: Lembar kerja ditolak (user dapat membuat ulang untuk tahun yang sama)

## Troubleshooting

### Error "Class not found"

```bash
composer dump-autoload
```

### Error "SQLSTATE[HY000] [2002] Connection refused"

Pastikan MySQL server berjalan dan konfigurasi di `.env` benar.

### Error "Mix manifest not found"

```bash
npm run build
```

### Error "The stream or file could not be opened"

```bash
chmod -R 775 storage bootstrap/cache
```

### Error file upload tidak tersimpan

```bash
php artisan storage:link
```

## Command Berguna

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize (production)
php artisan optimize

# Reset database dan seed ulang
php artisan migrate:fresh --seed

# Lihat routes
php artisan route:list
```

## License

Project ini menggunakan [MIT license](https://opensource.org/licenses/MIT).
