<?php
include_once '../config/connection.php';

// Ambil input dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Mencegah SQL Injection dengan mysqli_real_escape_string
$username = mysqli_real_escape_string($conn, $username);

// Query untuk mendapatkan user berdasarkan username
$query = "SELECT * FROM karyawan WHERE BINARY NAMA_USER = '$username'";
$res = mysqli_query($conn, $query);

if (mysqli_num_rows($res) == 1) {
    $usr = mysqli_fetch_array($res);

    // Verifikasi password yang diinput dengan password yang ada di database
    if (password_verify($password, $usr['PASSWORD_USER'])) {
        // Start session
        session_start();

        // Cek tipe user untuk mengarahkan ke halaman yang sesuai
        if ($usr['TIPE_USER'] == "Admin") {
            $_SESSION['jenis'] = "Admin";
            header("Location: ../views/master-alternatif.php");
        } else if ($usr['TIPE_USER'] == "User") {
            $_SESSION['jenis'] = "User";
            header("Location: ../views/pembobotan.php");
        }
    } else {
        // Jika password tidak cocok
        session_start();
        $_SESSION['message'] = 'Password salah';
        header("Location: ../views/login.php");
    }
} else {
    // Jika user tidak ditemukan
    session_start();
    $_SESSION['message'] = 'User tidak ditemukan';
    header("Location: ../views/login.php");
}

// Tutup koneksi database
mysqli_close($conn);
