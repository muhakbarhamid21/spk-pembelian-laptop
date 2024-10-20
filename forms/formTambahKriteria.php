<?php
include_once '../config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='../assets/css/customStyle.css' rel='stylesheet'>
    <link href='../assets/css/bootstrap.css' rel='stylesheet'>
    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <title>SPK Pembelian Laptop</title>
</head>

<body>

    <div class='container-fluid d-flex vh-100 justify-content-center align-items-center'>
        <div class='col-2 d-flex flex-column justify-content-start h-100 py-5' id='sidebar'>
            <button class='btn btn-light' onclick="location.href = 'master-alternatif.php'">Master Alternatif</button>
            <button class='btn btn-light' onclick="location.href = 'master-parameter.php'">Master Parameter</button>
            <button class='btn btn-light' onclick="location.href = 'master-user.php'">Master User</button>
            <div class='sidebarDivider align-self-center'></div>
            <button class='btn btn-light' id='buttonHitung'>Pembobotan</button>
        </div>
        <div class='col d-flex flex-column coreTab h-100 py-5'>
            <div class='container-fluid px-5 d-flex'>
                <div class='tableTitle'>Form Tambah Kriteria</div>
            </div>

            <form action="tambah_kriteria.php" method='post'>

                <?php
                $query = "SELECT max(ID_KRITERIA) FROM master_kriteria";
                $res = mysqli_query($conn, $query);
                $id_kriteria;
                while ($data = mysqli_fetch_array($res)) {
                    $id_kriteria = $data['0'];
                }
                $id_kriteria++;
                ?>

                <div class='container-fluid px-5 d-flex flex-column'>
                    <div class='row w-100'>
                        <div class='col-6'>
                            <div class='inputData'>
                                <h4>ID Kriteria</h4>
                                <input class="form-control" name="idKriteria" placeholder='ID Kriteria' value='<?= $id_kriteria ?>' readonly>
                            </div>
                            <div class='inputData'>
                                <h4>Nama Kriteria</h4>
                                <input class="form-control" name="namaKriteria" placeholder='Nama Kriteria' required>
                            </div>
                            <input class='btn btn-primary' style='position: relative; top: 1.5em' type="submit" value="Tambah Data">
                        </div>
                        <div class='col-6 px-5'>
                            <div class='inputData'>
                                <h4>Kategori Kriteria</h4>
                                <select class="form-select" name="katKriteria" required>
                                    <option value="">-- Choose --</option>
                                    <option value="Cost"> Cost </option>
                                    <option value="Benefit"> Benefit </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

</body>

</html>