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
    </style>
</head>

<body>
    <div class='container-fluid d-flex vh-100 justify-content-center align-items-center'
        style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
        <?php
        session_start();
        ?>
        <div class='col-2 d-flex flex-column justify-content-start h-100 py-5' id='sidebar'>
            <button class='btn btn-light' onclick="location.href = 'master-alternatif.php'" <?php if ($_SESSION['jenis'] == "User") {
                                                                                                echo "disabled";
                                                                                            } ?>>Master
                Alternatif</button>
            <button class='btn btn-light' onclick="location.href = 'master-parameter.php'">Master Parameter</button>
            <button class='btn btn-light' onclick="location.href = 'master-user.php'" <?php if ($_SESSION['jenis'] == "User") {
                                                                                            echo "disabled";
                                                                                        } ?>>Master User</button>
            <div class='sidebarDivider align-self-center'></div>
            <button class='btn btn-light' id='buttonHitung'
                onclick="location.href = 'pembobotan.php'">Pembobotan</button>
            <button class='btn btn-light' id='buttonHitung'
                onclick="location.href = '../controllers/logout.php'">Logout</button>
        </div>
        <div class='col d-flex flex-column coreTab h-100 py-5'>
            <div class='container-fluid mb-4 px-5 d-flex w-100 justify-content-between'>
                <div class='tableTitle'>Hasil</div>
                <div class='align-self-end'>
                    <?php
                    $switch = isset($_GET['switch']);
                    if ($switch == 1) { ?>
                        <button class='btn btn-primary' onclick=" location.href='hasil.php'">Batasi 5 terbesar</button>
                    <?php } else if ($switch == 0) { ?>
                        <button class='btn btn-primary' onclick=" location.href='hasil.php?switch=true'">Tampilkan semua
                            saran</button>
                    <?php }
                    ?>
                </div>
            </div>
            <div class='container-fluid px-5'>

                <?php
                $query = "SELECT * FROM master_kriteria";
                $res = mysqli_query($conn, $query);
                ?>
                <div style='overflow-y: auto; max-height: 25em'>
                    <table class=" table table-striped tr_hasil">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Laptop</th>
                                <th scope="col">Nilai Preferensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $num = 1;
                            if ($switch == 1) {
                                $jml = count($_SESSION['array']);
                            } else if ($switch == 0) {
                                $jml = 5;
                            }
                            for ($i = 0; $i < $jml; $i++) {
                            ?>
                                <tr onclick="window.location='detail.php?id=<?= $_SESSION['array'][$i][1] ?>'" class="data">
                                    <td scope="row"> <?= $num; ?> </td>
                                    <td scope="row"> <?= $_SESSION['array'][$i][2] ?> </td>
                                    <td scope="row"> <?= round($_SESSION['array'][$i][0], 3) ?> </td>
                                </tr>
                            <?php
                                $num++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class='w-100 mt-4'>
                    <button class="btn btn-primary w-100" onclick='location.href="pembobotan.php"'> Pembobotan Kembali
                    </button>
                </div>

                <div class='d-flex flex-column w-100 justify-content-between'>
                    <div class='pt-4 pb-2' style='font-size: 2em;'>Kesimpulan</div>
                    <div>Dari hasil perangkingan dapat dilihat alternatif <span
                            onclick="window.location='detail.php?id=<?= $_SESSION['array'][0][1] ?>'"
                            style='cursor: pointer; font-weight: 600; color: #0d6efd;'><?= $_SESSION['array'][0][2] ?></span>
                        mendapat nilai terbesar yaitu <span
                            onclick="window.location='detail.php?id=<?= $_SESSION['array'][0][1] ?>'"
                            style='cursor: pointer; font-weight: 600; color: #0d6efd;'><?= round($_SESSION['array'][0][0], 3) ?></span>
                        sehingga menjadi rank 1 (Rekomendasi Laptop Terbaik).
                        <!--</br></br><span onclick="window.location='../operations/perhitungan.php<?= $_SESSION['array'] ?>'"
                            style='cursor: pointer; font-weight: 600; color: #0d6efd;'>Lihat Perhitungan</span>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>