<?php
include_once '../config/connection.php';
$id_kriteria = $_GET['idKriteria'];
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
    <div class='container-fluid d-flex vh-100 justify-content-center align-items-center' style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
        <?php
        session_start();
        ?>
        <div class='col-2 d-flex flex-column justify-content-start h-100 py-5' id='sidebar'>
            <button class='btn btn-light' onclick="location.href = '../views/master-alternatif.php'" <?php if ($_SESSION['jenis'] == "User") {
                                                                                                            echo "disabled";
                                                                                                        } ?>>Master Alternatif</button>
            <button class='btn btn-light' onclick="location.href = '../views/master-parameter.php'">Master Parameter</button>
            <button class='btn btn-light' onclick="location.href = '../views/master-user.php'" <?php if ($_SESSION['jenis'] == "User") {
                                                                                                    echo "disabled";
                                                                                                } ?>>Master User</button>
            <div class='sidebarDivider align-self-center'></div>
            <button class='btn btn-light' id='buttonHitung'>Pembobotan</button>
        </div>
        <div class='col d-flex flex-column coreTab h-100 py-5'>
            <div class='container-fluid px-5 d-flex'>
                <div class='tableTitle'>Form Edit Kriteria</div>
            </div>

            <form action="../operations/edit_kriteria.php" method='post'>

                <?php
                $query = "SELECT * FROM master_kriteria WHERE ID_KRITERIA = " . $id_kriteria;
                $res = mysqli_query($conn, $query);
                while ($data = mysqli_fetch_array($res)) {
                    $kategori = $data['TIPE_KRITERIA'];
                    $nama = $data['NAMA_KRITERIA'];
                }
                ?>

                <div class='container-fluid px-5 d-flex flex-column'>
                    <div class='row w-100'>
                        <div class='col-6'>
                            <div class='inputData' style="display: none;">
                                <h4>ID Kriteria</h4>
                                <input class="form-control" name="idKriteria" placeholder='ID Kriteria' value='<?= $id_kriteria ?>' readonly>
                            </div>
                            <div class='inputData'>
                                <h4>Nama Kriteria</h4>
                                <input class="form-control" name="namaKriteria" value="<?= $nama; ?>" placeholder='Nama Kriteria' readonly required>
                            </div>
                            <input class='btn btn-success' style='position: relative; top: 1.5em' type="submit" value="Ubah Data">
                        </div>
                        <div class='col-6 px-5'>
                            <div class='inputData'>
                                <h4>Kategori Kriteria</h4>
                                <select class="form-select" name="katKriteria" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value="Cost" <?php if ($kategori == "Cost") {
                                                                echo 'selected';
                                                            } ?>> Cost (Terkecil paling baik) </option>
                                    <option value="Benefit" <?php if ($kategori == "Benefit") {
                                                                echo 'selected';
                                                            } ?>> Benefit (Terbesar paling baik) </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

</body>

</html>