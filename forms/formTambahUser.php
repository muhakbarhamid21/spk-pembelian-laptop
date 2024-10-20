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

        .inputData h4 {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .inputData {
            margin-bottom: 1.5rem;
        }

        .form-control,
        .form-select {
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
    </style>
</head>

<body>
    <div class='container-fluid d-flex vh-100 justify-content-center align-items-center' style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
        <div class='col-2 d-flex flex-column justify-content-start h-100 py-5' id='sidebar'>
            <button class='btn btn-light' onclick="location.href = '../views/master-alternatif.php'">Master Alternatif</button>
            <button class='btn btn-light' onclick="location.href = '../views/master-parameter.php'">Master Parameter</button>
            <button class='btn btn-light' onclick="location.href = '../views/master-user.php'">Master User</button>
            <div class='sidebarDivider align-self-center'></div>
            <button class='btn btn-light' id='buttonHitung'>Pembobotan</button>
        </div>
        <div class='col d-flex flex-column coreTab h-100 py-5'>
            <div class='container-fluid px-5 d-flex'>
                <div class='tableTitle'>Form Tambah User</div>
            </div>

            <form action="../operations/tambah_user.php" method='post'>

                <?php
                $query = "SELECT max(ID_USER) FROM karyawan";
                $res = mysqli_query($conn, $query);
                $id_karyawan;
                while ($data = mysqli_fetch_array($res)) {
                    $id_karyawan = $data['0'];
                }
                $id_karyawan++;
                ?>

                <div class='container-fluid px-5 d-flex flex-column'>
                    <div class='row w-100'>
                        <div class='col-6'>
                            <div class='inputData' style="display: none;">
                                <h4>ID User</h4>
                                <input class="form-control" name="idKaryawan" placeholder='ID User' value='<?= $id_karyawan ?>' readonly>
                            </div>
                            <div class='inputData'>
                                <h4>Nama User</h4>
                                <input class="form-control" name="namaKaryawan" placeholder='Nama User' required>
                            </div>
                            <div class='inputData'>
                                <h4>Password User</h4>
                                <input type='password' class="form-control" name="passwordKaryawan" placeholder='Password User' required>
                            </div>
                            <input class='btn btn-primary' style='position: relative; top: 1.5em' type="submit" value="Tambah Data">
                        </div>
                        <div class='col-6 px-5'>
                            <div class='inputData'>
                                <h4>Tipe User</h4>
                                <select class="form-select" name="tipeUser" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value='Admin'>Admin</option>
                                    <option value='User'>User</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

</body>

</html>