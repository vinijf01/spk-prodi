# SPK Pemilihan Program Studi

Sistem Pendukung Keputusan (SPK) Pemilihan Program Studi ini dibuat untuk membantu siswa dalam menentukan pilihan jurusan yang sesuai berdasarkan preferensi dan kriteria tertentu. Sistem ini menggunakan pendekatan berbasis pertanyaan dan penilaian untuk memberikan rekomendasi program studi.

## Fitur Utama

-   Form pemilihan awal berdasarkan preferensi
-   Pertanyaan lanjutan sesuai kriteria
-   Rekomendasi program studi berdasarkan hasil evaluasi
-   Pencetakan hasil rekomendasi ke dalam PDF
-   Panel Admin untuk mengelola:
    -   Program Studi
    -   Data Sekolah
    -   Pilihan Jawaban
    -   Kriteria Penilaian
    -   Pertanyaan
    -   Preferensi

## Metodologi Perhitungan

Aplikasi ini menggunakan gabungan dua metode populer dalam Sistem Pendukung Keputusan:

-   **AHP (Analytical Hierarchy Process)**  
    Digunakan untuk menentukan bobot kepentingan dari setiap kriteria yang ada berdasarkan perbandingan berpasangan. AHP membantu dalam menyusun hierarki keputusan dan mengukur konsistensi penilaian pengguna.

-   **TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)**  
    Digunakan untuk menghitung peringkat alternatif program studi berdasarkan kedekatannya dengan solusi ideal positif dan solusi ideal negatif. TOPSIS mempertimbangkan nilai preferensi siswa dan hasil bobot dari AHP untuk memberikan rekomendasi terbaik.

Kombinasi AHP dan TOPSIS memberikan pendekatan yang kuat dan objektif dalam menentukan program studi yang paling sesuai bagi siswa.

## Teknologi yang Digunakan

-   **Framework**: Laravel (PHP)
-   **Frontend**: Blade Template
-   **Database**: MySQL
-   **PDF Generator**: DomPDF
-   **Authentication**: Laravel Auth Middleware

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

## Instalasi

1. Clone repository ini:
    ```bash
    git clone https://github.com/vinijf01/spk-prodi.git
    cd spk-prodi
    ```
