# SPK Pemilihan Program Studi (Tugas Kuliah)

Sistem Pendukung Keputusan (SPK) Pemilihan Program Studi ini dibuat untuk membantu siswa dalam menentukan pilihan jurusan yang sesuai berdasarkan preferensi dan kriteria tertentu. Sistem ini menggunakan pendekatan berbasis pertanyaan dan penilaian untuk memberikan rekomendasi program studi.

---
## 📸 Cuplikan UI
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/abf18b14-49ca-4027-b685-088f211bfd18" />

### 🔍 Halaman Awal Pemilihan
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/ea0d6c22-2bac-4138-8e64-46131940d165" />

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/46630c05-f92b-4246-aa76-d818114e3bae" />

### ✅ Form Pertanyaan dan Penilaian
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/19afb88f-c289-4734-89f9-65a0da620b21" />

### 🧠 Hasil Rekomendasi
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/4b0b8271-743a-44e7-b4d2-c48aeb0b4fdf" />

### 📄 Laporan PDF
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/b8e3298b-694a-4bb0-81c1-846692b72241" />

### 🔐 Tampilan Login Admin
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/2bfec8b7-3469-4e54-be9e-6882bb949a3d" />

### 📊 Dashboard Admin
<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/ea582651-1729-4298-9731-c887cdf3e6de" />


---
## 🚀 Fitur Utama

- 🧑‍🎓 Pemilihan jurusan berdasarkan sekolah
- 📋 Kuesioner pertanyaan berbasis kriteria
- 🧠 Perhitungan berbasis AHP dan TOPSIS
- 📊 Hasil perangkingan & rekomendasi prodi
- 📄 Export laporan hasil dalam bentuk PDF profesional
- 🔒 Admin Panel CRUD: Prodi, Kriteria, Pertanyaan, Preferensi, Sekolah, dsb.

---
## 🧪 Metodologi Perhitungan

| Metode | Fungsi |
|--------|--------|
| **AHP** | Menentukan bobot tiap kriteria dari hasil perbandingan berpasangan |
| **TOPSIS** | Menentukan peringkat alternatif berdasarkan jarak ideal positif dan negatif |


---

## 🛠️ Teknologi & Stack

- **Backend**: Laravel 10.x
- **Database**: MySQL / MariaDB
- **Frontend**: Blade Template + Bootstrap
- **PDF Generator**: TCPDF
- **Auth**: Laravel Auth Middleware

## Struktur Routing

### Public (User)

| Route           | Method | Controller               | Fungsi                            |
| --------------- | ------ | ------------------------ | --------------------------------- |
| `/`             | GET    | `ProsesController@index` | Halaman awal                      |
| `/check`        | POST   | `pilihanProdi`           | Kirim preferensi awal             |
| `/pertanyaan`   | POST   | `pertanyaan`             | Pertanyaan berdasarkan preferensi |
| `/hasilpilihan` | POST   | `hasilPilihan`           | Menampilkan hasil rekomendasi     |
| `/cetak/hasil`  | GET    | `createPDF`              | Cetak hasil dalam format PDF      |

### Auth

| Route     | Method | Controller                 | Fungsi                            |
| --------- | ------ | -------------------------- | --------------------------------- |
| `/login`  | GET    | `LoginController@show`     | Tampilkan form login              |
| `/login`  | POST   | `LoginController@login`    | Proses login                      |
| `/logout` | GET    | `LogoutController@perform` | Logout (dengan middleware `auth`) |

### Admin Panel

| URL Prefix          | Controller             | Fungsi                  |
| ------------------- | ---------------------- | ----------------------- |
| `/dashboard/admin`  | `AdminController`      | Halaman dashboard admin |
| `/admin-prodi`      | `ProdiController`      | CRUD Program Studi      |
| `/admin-sekolah`    | `SekolahController`    | CRUD Data Sekolah       |
| `/admin-pilihan`    | `PilihanController`    | CRUD Pilihan Jawaban    |
| `/admin-kriteria`   | `KriteriaController`   | CRUD Kriteria Penilaian |
| `/admin-pertanyaan` | `PertanyaanController` | CRUD Pertanyaan         |
| `/admin-preferensi` | `PreferensiController` | CRUD Preferensi         |

## 📦 Instalasi

```bash
git clone https://github.com/vinijf01/spk-prodi.git
cd spk-prodi

# Install dependencies
composer install
npm install && npm run dev

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate:fresh --seed

# Jalankan server lokal
php artisan serve

## 🐳 Development dengan Docker (Laravel Sail)

Jika kamu tidak punya PHP lokal (mis. laptop kantor), gunakan Sail:

```bash
# 1) Install vendor (akan otomatis lewat container jika perlu)
./sail up -d

# 2) Setup app
./sail artisan key:generate
./sail artisan migrate:fresh --seed

# 3) Jalankan app
./sail artisan serve --host=0.0.0.0 --port=80
```
