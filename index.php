<?php
include_once '../config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='assets/css/bootstrap.css' rel='stylesheet'>
    <link href='assets/css/customStyle.css' rel='stylesheet'>
    <link rel="icon" href="assets/img/favicon.ico" type="image/png">
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

        #sidebar button:hover {
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
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .contentSection {
            font-size: 1.25rem;
            color: #555;
            line-height: 1.75;
            text-align: justify;
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
    <style>
        .fade-in {
            animation: fadeIn 2s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body>
    <div class='container-fluid d-flex vh-100 justify-content-center align-items-center'
        style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
        <div class='col d-flex flex-column coreTab h-100 py-5'>
            <div class='container-fluid px-5'>
                <div class='tableTitle'>Sistem Pendukung Keputusan Pembelian Laptop</div>
                <div class='contentSection'>
                    Selamat datang di aplikasi Sistem Pendukung Keputusan (SPK) untuk pembelian laptop. Aplikasi ini dirancang untuk membantu Anda dalam menentukan pilihan laptop terbaik sesuai dengan kebutuhan dan preferensi Anda. Dengan menggunakan metode yang telah terbukti seperti kombinasi metode AHP (Analytic Hierarchy Process) dan SAW (Simple Additive Weighting), aplikasi ini akan memudahkan Anda dalam membandingkan berbagai alternatif laptop berdasarkan kriteria yang Anda tentukan.
                </div>
                <div class='contentSection mt-4'>
                    Terdapat dua roles dalam aplikasi ini, yaitu User dan Admin. User dapat melakukan perhitungan berdasarkan preferensi (pembobotan) dan mengubah kriteria, sedangkan Admin memiliki akses lebih, seperti mengelola alternatif/data laptop, mengubah kriteria, mengelola pengguna, serta melakukan perhitungan berdasarkan preferensi.
                </div>
                
                <div class='mt-5 text-center'>
                    <button class='btn btn-primary bounce' onclick="location.href='views/login.php'">Mulai Pemilihan Laptop</button>
                </div>
            </div>

        </div>
    </div>
</body>

</html>