# SPK Pemilihan Program Studi

Sistem Pendukung Keputusan (SPK) untuk membantu siswa/mahasiswa dalam memilih program studi yang sesuai berdasarkan kriteria dan preferensi pribadi. Sistem ini mengimplementasikan kombinasi metode **AHP** (Analytic Hierarchy Process) dan **TOPSIS** (Technique for Order of Preference by Similarity to Ideal Solution) untuk menghasilkan rekomendasi yang terukur dan dapat dipertanggungjawabkan.

---

## 📋 Daftar Isi

- [Tentang Project](#tentang-project)
- [Fitur Utama](#fitur-utama)
- [Metodologi](#metodologi)
- [Arsitektur Sistem](#arsitektur-sistem)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Struktur Database](#struktur-database)
- [Panduan Instalasi](#panduan-instalasi)
  - [Prasyarat](#prasyarat)
  - [Opsi 1: Development dengan Docker (Recommended)](#opsi-1-development-dengan-docker-recommended)
  - [Opsi 2: Instalasi Manual (PHP Lokal)](#opsi-2-instalasi-manual-php-lokal)
- [Cara Menggunakan Aplikasi](#cara-menggunakan-aplikasi)
  - [Alur Pengguna (Public)](#alur-pengguna-public)
  - [Alur Admin](#alur-admin)
- [Menjalankan Test](#menjalankan-test)
- [Struktur Routing](#struktur-routing)
- [Kredensial Default](#kredensial-default)
- [Troubleshooting](#troubleshooting)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

---

## 📖 Tentang Project

Project ini adalah aplikasi web berbasis Laravel yang dirancang untuk:

1. **Membantu siswa** menentukan program studi yang paling sesuai dengan minat, kemampuan, dan preferensi mereka melalui kuesioner terstruktur.
2. **Memberikan rekomendasi berbasis data** menggunakan algoritma AHP untuk pembobotan kriteria dan TOPSIS untuk perankingan alternatif.
3. **Menyediakan panel admin** untuk mengelola data master (program studi, kriteria, pertanyaan, preferensi, dll) dan memantau hasil keputusan.

### Siapa yang Cocok Menggunakan Project Ini?

- Institusi pendidikan (SMA/SMK) yang ingin membantu siswa memilih jurusan kuliah.
- Universitas yang membutuhkan sistem rekomendasi prodi untuk calon mahasiswa.
- Developer yang ingin mempelajari implementasi AHP-TOPSIS dalam Laravel.

---

## ✨ Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| 🧑‍🎓 **Kuesioner Interaktif** | User mengisi data diri, asal sekolah, dan menjawab pertanyaan berbasis kriteria |
| 🧠 **Algoritma AHP-TOPSIS** | Kombinasi dua metode MCDM untuk hasil rekomendasi yang akurat |
| 📊 **Ranking & Visualisasi** | Menampilkan peringkat program studi beserta nilai preferensi |
| 📄 **Export PDF Profesional** | Laporan hasil rekomendasi dalam format PDF dengan kop surat, nomor dokumen, dan tanda tangan |
| 🔐 **Admin Panel** | CRUD lengkap untuk Program Studi, Kriteria, Pertanyaan, Preferensi, Sekolah, dan Pilihan |
| 👥 **Role-Based Access** | Pemisahan akses antara user biasa dan admin |
| 🛡️ **Rate Limiting** | Proteksi brute force pada halaman login |
| ✅ **Form Validation** | Validasi input ketat menggunakan FormRequest classes |
| 🐳 **Docker Ready** | Development environment siap pakai dengan Laravel Sail |
| 🧪 **Automated Testing** | Feature tests untuk user flow dan admin authentication |
| 🔄 **CI/CD** | GitHub Actions untuk automated testing pada setiap PR |

---

## 🧪 Metodologi

Sistem ini menggunakan dua metode Multi-Criteria Decision Making (MCDM):

### 1. AHP (Analytic Hierarchy Process)

**Fungsi:** Menentukan bobot relatif setiap kriteria berdasarkan perbandingan berpasangan.

**Cara Kerja:**
- Admin mengisi matriks perbandingan antar kriteria
- Sistem menghitung Consistency Ratio (CR) untuk validasi konsistensi
- Jika CR ≤ 10%, bobot dianggap konsisten dan dapat digunakan

### 2. TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)

**Fungsi:** Meranking alternatif program studi berdasarkan kedekatan dengan solusi ideal.

**Cara Kerja:**
- Normalisasi matriks keputusan
- Pembobotan menggunakan hasil AHP
- Menentukan solusi ideal positif dan negatif
- Menghitung jarak setiap alternatif ke kedua solusi ideal
- Menghitung nilai preferensi dan menentukan ranking

### Mengapa Kombinasi AHP + TOPSIS?

| Aspek | AHP | TOPSIS | Kombinasi |
|-------|-----|--------|-----------|
| Pembobotan | ✅ Subjektif dari expert | ❌ Tidak ada | ✅ AHP menyediakan bobot |
| Ranking | ❌ Tidak langsung | ✅ Langsung | ✅ TOPSIS menghasilkan ranking |
| Konsistensi | ✅ Ada uji CR | ❌ Tidak ada | ✅ Terukur |
| Kompleksitas | Sedang | Rendah | Optimal |

---

## 🏗️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                    USER (Public)                            │
│  Landing Page → Isi Data → Pilih Prodi → Kuesioner → Hasil  │
└──────────────────────────┬──────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                  LARAVEL APPLICATION                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐  │
│  │ Controllers  │  │ FormRequests │  │   SpkService     │  │
│  │ (Proses,     │  │ (Validation) │  │ (AHP + TOPSIS)   │  │
│  │  Admin)      │  │              │  │                  │  │
│  └──────┬───────┘  └──────────────┘  └────────┬─────────┘  │
│         │                                      │            │
│         ▼                                      ▼            │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐  │
│  │ Blade Views  │  │   Models     │  │   TCPDF Engine   │  │
│  │ (UI)         │  │ (Eloquent)   │  │ (PDF Generator)  │  │
│  └──────────────┘  └──────┬───────┘  └──────────────────┘  │
│                           │                                 │
└───────────────────────────┼─────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                      DATABASE (MySQL)                       │
│  users | prodis | kriteria | pertanyaan | preferensi | ...  │
└─────────────────────────────────────────────────────────────┘
```

---

## 💻 Teknologi yang Digunakan

| Kategori | Teknologi | Versi |
|----------|-----------|-------|
| **Backend** | Laravel Framework | 10.x |
| **Language** | PHP | 8.1+ |
| **Database** | MySQL | 8.0 |
| **Frontend** | Blade Template + Bootstrap | - |
| **PDF Engine** | TCPDF (elibyy/tcpdf-laravel) | - |
| **Authentication** | Laravel Session Auth | - |
| **Testing** | PHPUnit | - |
| **Containerization** | Docker + Laravel Sail | - |
| **CI/CD** | GitHub Actions | - |
| **Code Style** | Laravel Pint | - |

---

## 🗄️ Struktur Database

### Tabel Utama

| Tabel | Fungsi |
|-------|--------|
| `users` | Data pengguna dan admin (dengan kolom `is_admin`) |
| `prodis` | Data program studi |
| `kriteria` | Kriteria penilaian (biaya, prospek kerja, dll) |
| `pertanyaan` | Pertanyaan kuesioner yang terkait dengan kriteria |
| `preferensi` | Bobot perbandingan antar kriteria (untuk AHP) |
| `jurusan_sekolahs` | Data jurusan sekolah asal siswa |
| `pilihans` | Relasi antara sekolah dan prodi yang tersedia |

### Relasi Antar Tabel

```
users (1) ────< pilihans >──── (1) prodis
jurusan_sekolahs (1) ────< pilihans >──── (1) prodis
kriteria (1) ────< preferensi >──── (1) prodis
kriteria (1) ────< pertanyaan >──── (1) prodis
```

---

## 📦 Panduan Instalasi

### Prasyarat

**Untuk Opsi 1 (Docker - Recommended):**
- Docker Engine 20.10+
- Docker Compose V2
- Git

**Untuk Opsi 2 (Manual):**
- PHP 8.1+ dengan extensions: `pdo_mysql`, `mbstring`, `xml`, `curl`, `zip`
- Composer 2.x
- MySQL/MariaDB 8.0+
- Node.js 16+ (opsional, untuk asset compilation)

---

### Opsi 1: Development dengan Docker (Recommended)

Metode ini tidak memerlukan PHP atau MySQL lokal. Semua dependency berjalan di dalam container.

#### Langkah 1: Clone Repository

```bash
git clone https://github.com/vinijf01/spk-prodi.git
cd spk-prodi
```

#### Langkah 2: Setup Environment

```bash
# Copy file environment
cp .env.example .env
```

Pastikan konfigurasi database di `.env` sudah benar:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

#### Langkah 3: Build dan Start Containers

```bash
# Build image dan start containers di background
./sail up -d --build
```

> **Catatan:** Flag `--build` hanya diperlukan saat pertama kali atau setelah mengubah `Dockerfile`. Selanjutnya cukup `./sail up -d`.

#### Langkah 4: Setup Aplikasi

```bash
# Generate application key
./sail artisan key:generate

# Migrasi database dan isi data awal
./sail artisan migrate:fresh --seed
```

#### Langkah 5: Akses Aplikasi

Buka browser dan akses:

```
http://localhost
```

---

### Opsi 2: Instalasi Manual (PHP Lokal)

#### Langkah 1: Clone Repository

```bash
git clone https://github.com/vinijf01/spk-prodi.git
cd spk-prodi
```

#### Langkah 2: Install Dependencies

```bash
composer install
npm install && npm run build
```

#### Langkah 3: Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_prodi
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### Langkah 4: Setup Database

```bash
php artisan migrate:fresh --seed
```

#### Langkah 5: Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

---

## 🚀 Cara Menggunakan Aplikasi

### Alur Pengguna (Public)

1. **Halaman Utama**
   - Masukkan nama lengkap
   - Pilih jurusan sekolah asal
   - Klik "Lanjutkan"

2. **Pilih Program Studi**
   - Sistem menampilkan prodi yang tersedia berdasarkan sekolah
   - Pilih satu atau lebih prodi yang diminati
   - Klik "Lanjutkan"

3. **Isi Kuesioner**
   - Jawab pertanyaan berdasarkan kriteria yang ditampilkan
   - Setiap pertanyaan terkait dengan prodi yang dipilih
   - Klik "Lihat Hasil"

4. **Lihat Hasil Rekomendasi**
   - Sistem menampilkan ranking prodi berdasarkan perhitungan AHP-TOPSIS
   - Tabel perbandingan nilai setiap prodi
   - Info konsistensi AHP (CR dan CI)
   - Klik "Cetak PDF" untuk mengunduh laporan

5. **Download PDF**
   - Laporan profesional dengan kop surat, nomor dokumen, dan ranking
   - Tersedia dalam format PDF siap cetak

### Alur Admin

1. **Login**
   - Akses halaman login di `/login`
   - Gunakan kredensial admin (lihat [Kredensial Default](#kredensial-default))

2. **Dashboard**
   - Ringkasan data: jumlah prodi, kriteria, pertanyaan, dll
   - Navigasi ke menu pengelolaan

3. **Kelola Data Master**
   - **Program Studi**: Tambah/edit/hapus prodi
   - **Kriteria**: Kelola kriteria penilaian
   - **Pertanyaan**: Kelola pertanyaan kuesioner
   - **Preferensi**: Atur bobot perbandingan kriteria (untuk AHP)
   - **Sekolah**: Kelola data sekolah dan jurusan
   - **Pilihan**: Atur relasi sekolah-prodi

4. **Monitoring**
   - Lihat hasil perhitungan dan konsistensi AHP
   - Validasi Consistency Ratio (CR ≤ 10%)

---

## 🧪 Menjalankan Test

Project ini dilengkapi dengan automated tests menggunakan PHPUnit.

### Jalankan Semua Test

```bash
# Menggunakan Sail (Docker)
./sail artisan test

# Atau langsung via PHPUnit
./vendor/bin/phpunit
```

### Jalankan Test Spesifik

```bash
# Feature test untuk user flow
./sail artisan test --filter UserFlowTest

# Feature test untuk admin auth
./sail artisan test --filter AdminAuthTest

# Unit test
./sail artisan test --filter ExampleTest
```

### Output yang Diharapkan

```
PASS  Tests\Unit\ExampleTest
  ✓ that true is true

PASS  Tests\Feature\AdminAuthTest
  ✓ admin can login and access dashboard
  ✓ non admin cannot access admin dashboard

PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response

PASS  Tests\Feature\UserFlowTest
  ✓ user flow sets session and generates result

Tests:    5 passed (14 assertions)
Duration: 0.50s
```

> **Catatan:** Test menggunakan SQLite in-memory (dikonfigurasi di `phpunit.xml`), sehingga tidak memerlukan database MySQL untuk testing.

---

## 🛣️ Struktur Routing

### Public Routes (User)

| Route | Method | Fungsi |
|-------|--------|--------|
| `/` | GET | Halaman landing / form awal |
| `/check` | POST | Validasi data awal dan pilih prodi |
| `/pertanyaan` | POST | Tampilkan kuesioner berdasarkan prodi terpilih |
| `/hasilpilihan` | POST | Proses perhitungan dan tampilkan hasil |
| `/cetak/hasil` | GET | Download laporan PDF |

### Authentication Routes

| Route | Method | Fungsi |
|-------|--------|--------|
| `/login` | GET | Tampilkan form login |
| `/login` | POST | Proses autentikasi |
| `/logout` | GET | Logout user |

### Admin Panel Routes

| URL Prefix | Controller | Fungsi |
|------------|------------|--------|
| `/dashboard/admin` | `AdminController` | Dashboard utama admin |
| `/admin-prodi` | `ProdiController` | CRUD Program Studi |
| `/admin-sekolah` | `SekolahController` | CRUD Data Sekolah |
| `/admin-pilihan` | `PilihanController` | CRUD Pilihan Jawaban |
| `/admin-kriteria` | `KriteriaController` | CRUD Kriteria Penilaian |
| `/admin-pertanyaan` | `PertanyaanController` | CRUD Pertanyaan |
| `/admin-preferensi` | `PreferensiController` | CRUD Preferensi (Bobot AHP) |

> Semua route admin dilindungi middleware `auth` dan `admin`.

---

## 🔑 Kredensial Default

Setelah menjalankan `migrate:fresh --seed`, akun berikut tersedia:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@gmail.com` | `admin123` |

---

## 🔧 Troubleshooting

### Container `laravel.test` Langsung Exit

**Masalah:** Container tidak stay running setelah `./sail up -d`.

**Solusi:** Pastikan `Dockerfile` dan `docker-compose.yml` sudah benar:

```bash
# Rebuild container
./sail down -v
./sail up -d --build
```

### Error: "could not find driver"

**Masalah:** Extension `pdo_mysql` tidak terinstall di container.

**Solusi:** Pastikan `Dockerfile` memiliki baris:

```dockerfile
RUN docker-php-ext-install pdo_mysql
```

Lalu rebuild:

```bash
./sail build --no-cache
./sail up -d
```

### Error: Permission Denied pada `storage/`

**Masalah:** File permission tidak sesuai di dalam container.

**Solusi:**

```bash
# Fix dari dalam container sebagai root
docker exec -u root spk-prodi-laravel.test-1 chown -R 1000:1000 /var/www/html/storage /var/www/html/bootstrap/cache
```

### Database Connection Refused

**Masalah:** MySQL belum ready saat artisan command dijalankan.

**Solusi:** Tunggu beberapa detik sampai MySQL health check passed:

```bash
# Cek status container
docker ps --filter name=spk-prodi

# Tunggu status MySQL: "healthy"
# Lalu jalankan migrate
./sail artisan migrate:fresh --seed
```

### Test Gagal dengan Error "APP_KEY"

**Masalah:** Application key tidak ditemukan saat test.

**Solusi:** Pastikan `phpunit.xml` sudah memiliki:

```xml
<env name="APP_KEY" value="base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA="/>
```

---

## 🤝 Kontribusi

Kami terbuka untuk kontribusi! Berikut langkah-langkahnya:

1. **Fork repository ini**
2. **Buat branch fitur** (`git checkout -b feature/nama-fitur`)
3. **Commit perubahan** (`git commit -m 'feat: tambah fitur X'`)
4. **Push ke branch** (`git push origin feature/nama-fitur`)
5. **Buat Pull Request**

### Guidelines

- Gunakan **FormRequest** untuk validasi, jangan taruh rules di controller
- Gunakan **whitelist fields** (`$request->only([...])`), hindari `$request->all()`
- Tambahkan **test** untuk fitur baru
- Ikuti code style Laravel (bisa jalankan `./vendor/bin/pint`)
- Commit message mengikuti [Conventional Commits](https://www.conventionalcommits.org/)

---

## 📄 Lisensi

Project ini dibuat untuk keperluan akademik/pendidikan. Gunakan dengan tanggung jawab sendiri.

---

## 📞 Kontak & Support

Jika ada pertanyaan atau masalah:

- **Issue Tracker:** [GitHub Issues](https://github.com/vinijf01/spk-prodi/issues)
- **Email:** (sesuaikan dengan kontak Anda)

---

## 🙏 Acknowledgments

- **Laravel Framework** - PHP framework yang memudahkan development
- **Laravel Sail** - Docker development environment
- **TCPDF** - Library PDF generation
- **Bootstrap** - Frontend framework untuk UI

---

<div align="center">

**SPK Pemilihan Program Studi** | Universitas Metamedia

Dibuat dengan ❤️ untuk membantu siswa memilih masa depan yang tepat

</div>
