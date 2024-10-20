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
            margin: 0 auto;
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
    <div class='container-fluid d-flex vh-100 justify-content-center align-items-center'
        style='padding-top: 1.5rem; padding-bottom: 1.5rem; height: 100vh; box-sizing: border-box;'>
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
            <button class='btn btn-primary' id='buttonHitung'>Pembobotan</button>
            <button class='btn btn-light' id='buttonHitung'
                onclick="location.href = '../controllers/logout.php'">Logout</button>
        </div>
        <div class='col d-flex flex-column coreTab h-100 py-5' style='flex: 1;'>
            <div class='container-fluid px-5 d-flex w-100 justify-content-between'>
                <div class='tableTitle'>Pembobotan</div>
            </div>
            <div class='container-fluid px-5'>
                <?php
                $query = "SELECT * FROM master_kriteria";
                $res = mysqli_query($conn, $query);
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Parameter</th>
                            <th scope="col">Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $num = 1;
                        while ($data = mysqli_fetch_array($res)) {
                        ?>
                            <form action="../operations/perhitungan.php" method="post">
                                <tr>
                                    <input type="hidden" <?= 'name=id_kriteria' . $num ?>
                                        value="<?= $data['ID_KRITERIA'] ?>">
                                    <th scope="row"> <?= $num; ?> </th>
                                    <td> <?= $data['NAMA_KRITERIA'] ?> </td>
                                    <td>
                                        <select <?= 'name=prioritas' . $num ?> class='form-select form-control w-50'
                                            style='font-weight: 600' required>
                                            <option value='' disabled selected>-</option>
                                            <option value="1" style='font-weight: 600'>1 (Sangat Tidak Penting)</option>
                                            <option value="2" style='font-weight: 600'>2 (Tidak Penting Sekali)</option>
                                            <option value="3" style='font-weight: 600'>3 (Tidak Pending)</option>
                                            <option value="4" style='font-weight: 600'>4 (Agak Tidak Penting)</option>
                                            <option value="5" style='font-weight: 600'>5 (Normal)</option>
                                            <option value="6" style='font-weight: 600'>6 (Agak Penting)</option>
                                            <option value="7" style='font-weight: 600'>7 (Penting)</option>
                                            <option value="8" style='font-weight: 600'>8 (Sangat Penting Sekali)</option>
                                            <option value="9" style='font-weight: 600'>9 (Sangat Sangat Penting)</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php
                            $num++;
                        }
                            ?>
                    </tbody>
                </table>
                <div class='w-100'>
                    <input type='submit' class="btn btn-primary w-100" value="Mulai Perhitungan"
                        style="margin-top: 20px;">
                </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>