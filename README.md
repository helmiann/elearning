# Simple E-Learning Platform

Aplikasi E-Learning sederhana untuk technical assessment Web Developer (Track A).
Admin mengelola course dan lesson berupa video. Student melihat course, membuka detail course, memilih lesson, dan memutar video.

## Fitur

**Admin**
- Login dengan akses halaman dibedakan berdasarkan role
- CRUD course (judul, deskripsi, status publikasi)
- CRUD lesson di dalam course, dengan pengurutan (tombol naik/turun)
- Upload video per lesson (AJAX dengan progress bar, status `uploading` / `ready` / `failed`)

**Student**
- Login, lalu melihat daftar course yang dipublikasikan
- Melihat detail course beserta daftar lesson
- Memutar video lesson (hanya untuk pengguna yang login dan berhak mengakses)

## Teknologi dan alasan pemilihan

| Teknologi | Alasan |
|---|---|
| Laravel (PHP 8.3.28) | Framework yang diwajibkan; routing, middleware, policy, dan Eloquent sudah tersedia sehingga kode tetap ringkas |
| MySQL | Database relasional yang sesuai untuk relasi course dan lesson |
| Blade + Tailwind CSS v4 | Server-side rendering sederhana tanpa SPA, cukup untuk kebutuhan aplikasi |
| Laravel Breeze (Blade) | Autentikasi yang sudah teruji, lalu ditambah role dan middleware sendiri |
| JavaScript (XMLHttpRequest) | Upload asynchronous dengan progress bar tanpa library tambahan |
| Local private storage | Video tidak punya URL publik; akses lewat controller yang mengecek otorisasi |

## Requirement

- PHP 8.2 atau lebih baru (ekstensi umum Laravel: mbstring, openssl, pdo_mysql, fileinfo)
- Composer
- Node.js 24.14.1 dan npm
- MySQL 8 (atau MariaDB yang setara)

## Instalasi

```bash
git clone https://github.com/helmiann/elearning.git elearning
cd elearning

composer install
cp .env.example .env        # Windows: copy .env.example .env
php artisan key:generate
```

Buat database kosong bernama `elearning`, lalu sesuaikan `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elearning
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi dan data demo:

```bash
php artisan migrate --seed
npm install
```

## Konfigurasi upload video (penting)

Bawaan PHP hanya mengizinkan upload sekitar 2 MB. Ubah di `php.ini` (lokasinya dapat dilihat dengan `php --ini`):

```ini
upload_max_filesize = 256M
post_max_size = 260M
```

Restart server PHP setelah mengubahnya. Batas validasi aplikasi adalah 200 MB, format MP4 atau WebM.

## Menjalankan aplikasi

Buka dua terminal di folder proyek:

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Buka http://127.0.0.1:8000. Alternatif tanpa terminal kedua: jalankan `npm run build` sekali, lalu cukup `php artisan serve`.

## Akun demo

| Role | Email | Password |
|---|---|---|
| Admin | admin@example.com | password |
| Student | student@example.com | password |

Data demo berisi 3 course (2 published, 1 draft) beserta lesson. Video tidak ikut di repository, jadi untuk mencoba pemutaran: login sebagai admin, buka **Kelola Course → Lesson → Edit**, lalu unggah sebuah video MP4 pendek.

## Alur penggunaan singkat

1. Admin login, membuat course, menambah lesson, mengurutkan lesson, lalu mengunggah video.
2. Admin mencentang **Publikasikan course** agar course terlihat oleh student.
3. Student login, membuka course, memilih lesson, dan memutar video.

## Keputusan teknis dan asumsi

- Dua role saja (`admin`, `student`), disimpan sebagai kolom `role` di tabel `users`.
- Pendaftaran akun lewat halaman register selalu menghasilkan role `student`. Akun admin hanya dibuat lewat seeder. Kolom `role` tidak ada di `$fillable` untuk mencegah mass assignment.
- Student hanya dapat mengakses course yang dipublikasikan; admin dapat mengakses semua course (untuk pratinjau). Aturan ini berada di satu tempat, yaitu `CoursePolicy`.
- Video disimpan di `storage/app/private/videos/{course_id}/` dengan nama acak dan tidak dapat diakses lewat URL langsung.
- Streaming video memakai `response()->file()` sehingga mendukung request Range (video dapat digeser).
- Urutan lesson memakai kolom `position`; tombol naik/turun menukar nilai `position` dengan lesson tetangga di dalam satu transaksi.
- Menghapus lesson atau course ikut menghapus file video terkait.
- Setiap student dapat membuka semua course yang dipublikasikan (tidak ada enrollment), karena tidak diminta pada brief.

## Keterbatasan dan bagian yang belum selesai

- Upload diproses sinkron tanpa queue. Status `uploading` hanya berlangsung selama request berjalan; jika koneksi terputus di tengah upload, status lesson tidak berubah dan tidak ada pembersihan otomatis.
- Video tidak ditranskode (tanpa FFmpeg/HLS). Hanya MP4 dan WebM yang diterima, dan kompatibilitas pemutaran bergantung pada codec video.
- Video dilindungi dengan login dan status publikasi, tetapi pengguna yang sah tetap bisa merekam atau mengunduh video lewat tools browser. Proteksi penuh (DRM atau token berumur pendek) di luar lingkup assessment.
- Tidak ada pelacakan progress belajar, enrollment, atau pencarian course.
- Pengurutan lesson memakai tombol naik/turun, bukan drag and drop.
- Pengujian dilakukan manual; belum ada automated test.
- `npm audit` melaporkan kerentanan pada dependency tooling pengembangan (picomatch); tidak memengaruhi aplikasi saat dijalankan.

## Dokumentasi desain

Lihat [docs/DESIGN.md](docs/DESIGN.md): system design, ERD, flowchart upload video, sequence diagram pengelolaan dan pemutaran video, serta keputusan desain UI.
