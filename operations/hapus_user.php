<?php
include_once '../config/connection.php';

$id_karyawan = $_GET['id_karyawan'];

$query = "DELETE FROM karyawan WHERE ID_USER= $id_karyawan";
$res = mysqli_query($conn, $query);

header("Location: ../views/master-user.php");
