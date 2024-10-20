<?php
include_once '../config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='../assets/css/bootstrap.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href='../assets/css/customStyle.css' rel='stylesheet'>
    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <title>SPK Pembelian Laptop</title>
    <style>
        body {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            font-family: 'Poppins', sans-serif;
        }

        #sidebar {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            max-width: 250px;
            margin: 1.5rem;
        }

        #sidebar button {
            margin-bottom: 1rem;
            border-radius: 10px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        #sidebar button:disabled {
            background: #f0f0f0;
            color: #aaa;
        }

        #sidebar button:hover:not(:disabled) {
            background: #f5576c;
            color: #fff;
        }

        .sidebarDivider {
            width: 80%;
            height: 2px;
            background: #f093fb;
            margin: 1.5rem 0;
        }

        #buttonHitung {
            background: #f5576c;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            transition: background 0.3s ease;
        }

        #buttonHitung:hover {
            background: #f093fb;
        }

        .coreTab {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin: 1.5rem;
        }

        .tableTitle {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
        }

        table {
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        th,
        td {
            text-align: center;
            padding: 1rem;
            font-weight: 500;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            background: #f093fb;
            border: none;
            font-weight: 600;
            padding: 1rem;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #f5576c;
        }

        .btn-success {
            background: #28a745;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .btn-danger:hover {
            background: #c82333;
        }
    </style>
</head>

<body>
    <div class='container-fluid d-flex vh-100 justify-content-center align-items-center'
        style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
        <?php
        session_start();
        if ($_SESSION['jenis'] == "usr") {
            header("Location: pembobotan.php");
        }
        ?>
        <div class='col-2 d-flex flex-column justify-content-start h-100 py-5' id='sidebar'>
            <button class='btn btn-light' onclick="location.href = 'master-alternatif.php'">Master Alternatif</button>
            <button class='btn btn-light' onclick="location.href = 'master-parameter.php'">Master Parameter</button>
            <button class='btn btn-primary'>Master User</button>
            <div class='sidebarDivider align-self-center'></div>
            <button class='btn btn-light' id='buttonHitung'
                onclick="location.href = 'pembobotan.php'">Pembobotan</button>
            <button class='btn btn-light' id='buttonHitung' onclick="location.href = '../controllers/logout.php'">Logout</button>
        </div>
        <div class='col d-flex flex-column coreTab h-100 py-5'>
            <div class='container-fluid px-5 d-flex w-100 justify-content-between'>
                <div class='tableTitle'>Master User</div>
                <div class='align-self-end'>
                    <button class='btn btn-primary' onclick="location.href = '../forms/formTambahUser.php'"
                        style="margin-bottom: 20px;">Tambah Data</button>
                </div>
            </div>
            <div class='container-fluid px-5'>
                <?php
                $query = "SELECT * FROM karyawan";
                $res = mysqli_query($conn, $query);
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama User</th>
                            <th scope="col">Tipe User</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $num = 1;
                        while ($data = mysqli_fetch_array($res)) {
                        ?>
                            <tr>
                                <th scope="row"> <?= $num; ?> </th>
                                <td> <?= $data['NAMA_USER'] ?> </td>
                                <td> <?= $data['TIPE_USER'] ?> </td>
                                <td>
                                    <a href="../forms/formEditUser.php?id_karyawan=<?= $data["ID_USER"] ?>">
                                        <button type="button" class="btn btn-success">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button> </a>
                                    <?php if (mysqli_num_rows($res) != 1) { ?>
                                        <button class='btn btn-danger' onclick="hapusKaryawan(<?= $data["ID_USER"] ?>)"><i
                                                class="bi bi-trash-fill"></i></button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                            $num++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <script>
                function hapusKaryawan(id_karyawan) {
                    if (confirm('Apakah anda yakin menghapus user ini?')) {
                        window.location = "../operations/hapus_user.php?id_karyawan=" + id_karyawan;
                    }
                }
            </script>
</body>

</html>