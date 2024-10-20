<?php
include_once '../config/connection.php';
session_start();

// Ambil data dari form
$id_karyawan = intval($_POST['idKaryawan']);  // Mengonversi ID menjadi integer
$nama_karyawan = mysqli_real_escape_string($conn, $_POST['namaKaryawan']);
$tipe_user = mysqli_real_escape_string($conn, $_POST['tipeUser']);
$password_karyawan = $_POST['passwordKaryawan'];  // Tidak langsung di-hash

// Cek apakah password baru diisi
if (!empty($password_karyawan)) {
  // Hash password baru jika diisi
  $hashed_password = password_hash($password_karyawan, PASSWORD_BCRYPT);
  // Update query untuk nama, tipe, dan password
  $query = "UPDATE karyawan SET NAMA_USER = '$nama_karyawan', PASSWORD_USER = '$hashed_password', TIPE_USER = '$tipe_user' WHERE ID_USER = $id_karyawan";
} else {
  // Jika password tidak diubah, jangan perbarui password
  $query = "UPDATE karyawan SET NAMA_USER = '$nama_karyawan', TIPE_USER = '$tipe_user' WHERE ID_USER = $id_karyawan";
}

// Eksekusi query
if (mysqli_query($conn, $query)) {
  // Redirect ke halaman master user jika berhasil
  header("Location: ../views/master-user.php");
  exit();
} else {
  // Jika terjadi kesalahan, tampilkan pesan error
  echo "Error updating record: " . mysqli_error($conn);
}

// Tutup koneksi database
mysqli_close($conn);
