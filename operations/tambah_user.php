<?php
include_once '../config/connection.php';
session_start();

// Ambil data dari form
$id_karyawan = intval($_POST['idKaryawan']);
$nama_karyawan = mysqli_real_escape_string($conn, $_POST['namaKaryawan']);
$password_karyawan = $_POST['passwordKaryawan'];
$tipe_user = mysqli_real_escape_string($conn, $_POST['tipeUser']);

// Hash password sebelum disimpan (tidak ada ketentuan panjang password)
$hashed_password = password_hash($password_karyawan, PASSWORD_BCRYPT);

// Query untuk memasukkan data user baru ke dalam database
$query = "INSERT INTO karyawan (ID_USER, NAMA_USER, PASSWORD_USER, TIPE_USER) VALUES ($id_karyawan, '$nama_karyawan', '$hashed_password', '$tipe_user')";
$res = mysqli_query($conn, $query);

// Redirect ke halaman master user setelah berhasil
if ($res) {
  $_SESSION['success_message'] = 'User berhasil ditambahkan';
  header("Location: ../views/master-user.php");
} else {
  echo "Error: " . mysqli_error($conn);
}

// Tutup koneksi database
mysqli_close($conn);
