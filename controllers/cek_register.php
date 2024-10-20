<?php
session_start();

include('../config/connection.php');

// Ambil input dari form
$username = $_POST['username'];
$password = $_POST['password'];
$tipe_user = $_POST['tipe_user'];

// Mencegah SQL Injection dengan mysqli_real_escape_string
$username = mysqli_real_escape_string($conn, $username);
$tipe_user = mysqli_real_escape_string($conn, $tipe_user);

// Query untuk cek apakah username sudah terdaftar
$check_username_query = "SELECT * FROM karyawan WHERE NAMA_USER = '$username'";
$result = mysqli_query($conn, $check_username_query);

// Jika username sudah ada
if (mysqli_num_rows($result) > 0) {
  $_SESSION['error_message'] = 'Username sudah terdaftar. Silakan gunakan username lain.';
  header("Location: ../views/register.php");
  exit();
} else {
  // Jika username belum ada, hash password dan simpan ke database
  $hashed_password = password_hash($password, PASSWORD_BCRYPT);

  // Query untuk menyimpan user baru
  $query = "INSERT INTO karyawan (NAMA_USER, PASSWORD_USER, TIPE_USER) VALUES ('$username', '$hashed_password', '$tipe_user')";

  // Eksekusi query
  if (mysqli_query($conn, $query)) {
    $_SESSION['success_message_register'] = 'Registrasi sukses! Silahkan login.';
    header("Location: ../views/login.php");
    exit();
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
  }
}

// Tutup koneksi database
mysqli_close($conn);
