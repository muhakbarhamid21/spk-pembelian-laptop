# SPK Pembelian Laptop

## Deskripsi

Aplikasi berbasis web ini merupakan Sistem Pendukung Keputusan (SPK) untuk membantu pengguna dalam memilih laptop terbaik berdasarkan berbagai kriteria menggunakan metode AHP (Analytic Hierarchy Process) dan SAW (Simple Additive Weighting).

Aplikasi ini memiliki dua role user, yaitu:

- **User**: Dapat mengubah jenis kriteria antara `cost` atau `benefit`, melakukan pembobotan kriteria, serta menghitung dan melihat hasil rekomendasi.
- **Admin**: Memiliki akses penuh untuk menambah, mengedit, menghapus alternatif (laptop), mengelola kriteria, melakukan pembobotan, serta mengelola pengguna.

## Fitur

### 1. Kriteria

Kriteria yang digunakan dalam aplikasi ini adalah sebagai berikut:

- **Harga**
- **Ukuran Layar**
- **Jenis Prosesor**
- **Kapasitas Memori**
- **Tipe Memori**
- **Kapasitas Penyimpanan**
- **Aksesoris**

Kriteria dapat diubah oleh user dan admin antara `cost` dan `benefit` sesuai kebutuhan.

### 2. Role & Hak Akses

- **User**

  - Mengubah kriteria (cost atau benefit).
  - Melakukan pembobotan kriteria menggunakan metode AHP.
  - Melakukan perhitungan keputusan menggunakan metode SAW.
  - Melihat hasil perhitungan dan rekomendasi laptop terbaik.

- **Admin**
  - Menambah, mengedit, menghapus alternatif (laptop).
  - Mengelola kriteria (menambah, mengedit, menghapus).
  - Mengubah kriteria antara `cost` dan `benefit`.
  - Melakukan pembobotan kriteria.
  - Mengelola pengguna (menambah, mengedit, menghapus user).

## Teknologi yang Digunakan

- **Backend**: PHP (Native)
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Metode SPK**: AHP dan SAW

## Instalasi

1. Clone repository ini ke folder `htdocs` di XAMPP:

   - Buka terminal atau command line.
   - Navigasi ke folder `htdocs` XAMPP:

     ```bash
     cd /Applications/XAMPP/xamppfiles/htdocs
     ```

   - Clone repository dari GitHub:

     ```bash
     git clone https://github.com/muhakbarhamid21/spk-pembelian-laptop
     ```

2. Pindahkan ke direktori project:

   ```bash
   cd spk-pembelian-laptop
   ```
