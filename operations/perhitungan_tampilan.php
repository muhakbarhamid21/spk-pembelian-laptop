<?php

session_start();

include_once '../config/connection.php';

$query = "SELECT * FROM master_kriteria";
$res = mysqli_query($conn, $query);


// TODO: Inisialisasi variabel-variabel yang akan digunakan dalam perhitungan
$id_kriteria = array();                 // parameter
$prioritas = array();                   // bobot
$perbandingan = array();                // Matriks perbandingan berpasangan
$penjumlahan_perbandingan = array();    // Menyimpan jumlah tiap kolom matriks perbandingan
$pembagian_perbandingan = array();      // Matriks normalisasi perbandingan
$rata_rata_kriteria = array();          // Menyimpan rata-rata bobot parameter
$a3 = array();                          // Hasil perkalian matriks perbandingan dan rata-rata parameter
$a4 = array();                          // Hasil pembagian a3 dengan rata-rata parameter
$lambda_max = 0;                        // Menyimpan nilai lambda max
$ci = 0;                                // Menyimpan nilai Consistency Index (CI)
$random_index = 1.32;                   // Nilai Random Index (RI) untuk perhitungan konsistensi
$cr = 0;                                // Menyimpan nilai Consistency Ratio (CR)


// TODO: PROSES ANALYTICAL HIERARCHY PROCESS (AHP)

// TODO: Memasukkan [PARAMETER] ke dalam array dari inputan pengguna
for ($i = 1; $i <= mysqli_num_rows($res); $i++) {
    array_push($id_kriteria, $_POST['id_kriteria' . strval($i)]);
}

echo '<br>';

// TODO: Memasukkan [BOBOT] ke dalam array dari inputan pengguna
for ($i = 1; $i <= mysqli_num_rows($res); $i++) {
    array_push($prioritas, $_POST['prioritas' . strval($i)]);
}

// TODO: Menghitung matriks perbandingan berpasangan menggunakan AHP
for ($i = 0; $i < count($id_kriteria); $i++) {
    for ($j = 0; $j < count($id_kriteria); $j++) {
        $perbandingan[$i][$j] = round($prioritas[$i] / $prioritas[$j], 2);
    }
}

// TODO: Menghitung penjumlahan kolom pada matriks perbandingan
for ($i = 0; $i < count($perbandingan); $i++) {
    $hasil = 0;
    for ($j = 0; $j < count($perbandingan); $j++) {
        $hasil = $hasil + $perbandingan[$j][$i];
    }
    $penjumlahan_perbandingan[0][$i] = $hasil;
}

// TODO: Membagi nilai pada setiap elemen matriks dengan total kolomnya
for ($i = 0; $i < count($perbandingan); $i++) {
    for ($j = 0; $j < count($perbandingan); $j++) {
        $pembagian_perbandingan[$i][$j] = round($perbandingan[$i][$j] / $penjumlahan_perbandingan[0][$j], 2);
    }
}

// TODO: Menghitung rata-rata [PARAMETER]
for ($i = 0; $i < count($pembagian_perbandingan); $i++) {
    $hasil = 0;
    for ($j = 0; $j < count($pembagian_perbandingan); $j++) {
        $hasil = $hasil + $pembagian_perbandingan[$i][$j];
    }
    $hasil = $hasil / count($pembagian_perbandingan);
    $rata_rata_kriteria[$i][0] = round($hasil, 2);
}

$a3 = perkalian_matriks($perbandingan, $rata_rata_kriteria);

for ($i = 0; $i < count($a3); $i++) {
    $a4[$i][0] = round($a3[$i][0] / $rata_rata_kriteria[$i][0], 2);
}

$temp = 0;
for ($i = 0; $i < count($a4); $i++) {
    $temp = $temp + $a4[$i][0];
}

// TODO: Menghitung nilai lambda max
$lambda_max = $temp / count($a4);

// TODO: Menghitung Consistency Index (CI) dan Consistency Ratio (CR)
$ci = ($lambda_max - count($id_kriteria)) / (count($id_kriteria) - 1);
$cr = $ci / $random_index;


// TODO: SIMPLE ADDITIVE WEIGHTING (SAW)

// TODO: Mengambil daftar [ALTERNATIF] untuk evaluasi menggunakan metode SAW
$daftar_id_laptop = array();
$query = "SELECT distinct(ID_LAPTOP) FROM memiliki";
$res = mysqli_query($conn, $query);
while ($temporary = mysqli_fetch_array($res)) {
    array_push($daftar_id_laptop, $temporary[0]);
}

// TODO: Mengambil nilai [PARAMETER] setiap laptop sebelum normalisasi
$matriks_sebelum_normalisasi = array();
for ($i = 0; $i < count($daftar_id_laptop); $i++) {
    $arrayBaris = array();
    $query2 = "SELECT VALUE FROM memiliki WHERE ID_LAPTOP = " . $daftar_id_laptop[$i] . " ORDER BY ID_LAPTOP, ID_KRITERIA";
    $rest = mysqli_query($conn, $query2);
    while ($temporary = mysqli_fetch_array($rest)) {
        array_push($arrayBaris, $temporary[0]);
    }
    array_push($matriks_sebelum_normalisasi, $arrayBaris);
}

// TODO: Mengambil [KRITERIA] (Cost atau Benefit) dari database
$daftar_tipe_kriteria = array();
$query = "SELECT TIPE_KRITERIA FROM master_kriteria";
$res = mysqli_query($conn, $query);
while ($temporary = mysqli_fetch_array($res)) {
    array_push($daftar_tipe_kriteria, $temporary[0]);
}

// echo $daftar_tipe_kriteria[0];
// echo "<br>";

// TODO: Melakukan normalisasi matriks berdasarkan [KRITERIA]
$matriks_setelah_normalisasi = array();
for ($i = 0; $i < count($daftar_tipe_kriteria); $i++) {
    if ($daftar_tipe_kriteria[$i] == "Cost") {
        $min = min(array_column($matriks_sebelum_normalisasi, $i));
        for ($j = 0; $j < count($daftar_id_laptop); $j++) {
            $matriks_setelah_normalisasi[$j][$i] = $min / $matriks_sebelum_normalisasi[$j][$i];
        }
    } else if ($daftar_tipe_kriteria[$i] == "Benefit") {
        $max = max(array_column($matriks_sebelum_normalisasi, $i));
        for ($j = 0; $j < count($daftar_id_laptop); $j++) {
            $matriks_setelah_normalisasi[$j][$i] = $matriks_sebelum_normalisasi[$j][$i] / $max;
        }
    }
}

// TODO: Menghitung hasil rekomendasi menggunakan metode SAW
$hasil_saran = perkalian_matriks($matriks_setelah_normalisasi, $rata_rata_kriteria);

// TODO: Menambahkan ID laptop ke hasil rekomendasi
for ($i = 0; $i < count($daftar_id_laptop); $i++) {
    $hasil_saran[$i][1] = $daftar_id_laptop[$i];
}

// TODO: Fungsi untuk perkalian matriks
function perkalian_matriks($matriks_a, $matriks_b)
{
    $hasil = array();
    for ($i = 0; $i < sizeof($matriks_a); $i++) {
        for ($j = 0; $j < sizeof($matriks_b[0]); $j++) {
            $temp = 0;
            for ($k = 0; $k < sizeof($matriks_b); $k++) {
                $temp += $matriks_a[$i][$k] * $matriks_b[$k][$j];
            }
            $hasil[$i][$j] = $temp;
        }
    }
    return $hasil;
}


//TODO: OUTPUT


include_once '../config/connection.php';

session_start();


$query = "SELECT * FROM master_kriteria";
$res = mysqli_query($conn, $query);

// Tabel Parameter
echo "<h3>Tabel: Parameter</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Simbol</th><th>Parameter</th></tr>";
$counter = 1;
while ($row = mysqli_fetch_array($res)) {
    echo "<tr><td>C" . $counter . "</td><td>" . $row['NAMA_KRITERIA'] . "</td></tr>";
    $counter++;
}
echo "</table><br><br>";


// Tabel Bobot
echo "<h3>Tabel: Bobot</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>Parameter</th><th>Bobot</th></tr>";
for ($i = 0; $i < count($prioritas); $i++) {
    echo "<tr><td>C" . ($i + 1) . "</td><td>" . $prioritas[$i] . "</td></tr>";
}
echo "</table><br><br>";

echo "<br><h2>PROSES ANALYTICAL HIERARCHY PROCESS (AHP)</h2><br>";


// Matriks Perbandingan Berpasangan
echo "<h3>Tabel: Matriks Perbandingan Berpasangan</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
echo "<td></td>";
for ($j = 0; $j < count($id_kriteria); $j++) {
    echo "<td>C" . ($j + 1) . "</td>";
}
echo "</tr>";
for ($i = 0; $i < count($id_kriteria); $i++) {
    echo "<tr>";
    echo "<td>C" . ($i + 1) . "</td>";
    for ($j = 0; $j < count($id_kriteria); $j++) {
        echo "<td>" . $perbandingan[$i][$j] . "</td>";
    }
    echo "</tr>";
}
echo "</table><br><br>";


// Hasil Penjumlahan Setiap Kolom pada Matriks Perbandingan Berpasangan
echo "<h3>Tabel: Hasil Penjumlahan Setiap Kolom pada Matriks Perbandingan Berpasangan</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
for ($i = 0; $i < count($penjumlahan_perbandingan[0]); $i++) {
    echo "<td>C" . ($i + 1) . "</td>";
}
echo "</tr>";
echo "<tr>";
for ($i = 0; $i < count($penjumlahan_perbandingan[0]); $i++) {
    echo "<td>" . $penjumlahan_perbandingan[0][$i] . "</td>";
}
echo "</tr>";
echo "</table><br><br>";


// Hasil Pembagian Perbandingan yang Telah Dinormalisasi
echo "<h3>Tabel: Hasil Pembagian Perbandingan yang Telah Dinormalisasi</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
echo "<td></td>";
for ($j = 0; $j < count($pembagian_perbandingan); $j++) {
    echo "<td>C" . ($j + 1) . "</td>";
}
echo "</tr>";
for ($i = 0; $i < count($pembagian_perbandingan); $i++) {
    echo "<tr>";
    echo "<td>C" . ($i + 1) . "</td>";
    for ($j = 0; $j < count($pembagian_perbandingan); $j++) {
        echo "<td>" . $pembagian_perbandingan[$i][$j] . "</td>";
    }
    echo "</tr>";
}
echo "</table><br><br>";


// Nilai Rata-Rata Parameter (A2)
echo "<h3>Tabel: Nilai Rata-Rata Parameter (A2)</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
for ($i = 0; $i < count($rata_rata_kriteria); $i++) {
    echo "<td>C" . ($i + 1) . "</td>";
}
echo "</tr>";
echo "<tr>";
for ($i = 0; $i < count($rata_rata_kriteria); $i++) {
    echo "<td>" . $rata_rata_kriteria[$i][0] . "</td>";
}
echo "</tr>";
echo "</table><br><br>";


// Nilai Perkalian Matriks Perbandingan dan Rata-Rata Parameter (A3)
echo "<h3>Tabel: Nilai Perkalian Matriks Perbandingan dan Rata-Rata Parameter (A3)</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
for ($i = 0; $i < count($a3); $i++) {
    echo "<td>C" . ($i + 1) . "</td>";
}
echo "</tr>";
echo "<tr>";
for ($i = 0; $i < count($a3); $i++) {
    echo "<td>" . $a3[$i][0] . "</td>";
}
echo "</tr>";
echo "</table><br><br>";


// Nilai Konsistensi Perbandingan Parameter (A4)
echo "<h3>Tabel: Nilai Konsistensi Perbandingan Parameter (A4)</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
for ($i = 0; $i < count($a4); $i++) {
    echo "<td>C" . ($i + 1) . "</td>";
}
echo "</tr>";
echo "<tr>";
for ($i = 0; $i < count($a4); $i++) {
    echo "<td>" . $a4[$i][0] . "</td>";
}
echo "</tr>";
echo "</table><br><br>";


// Consistency Index (CI)
echo "<h3>Tabel: Consistency Index (CI)</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'><tr><td>" . $ci . "</td></tr></table><br><br>";


// Consistency Ratio (CR)
echo "<h3>Tabel: Consistency Ratio (CR)</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'><tr><td>" . $cr . "</td></tr></table><br><br>";


echo "<br><h2>SIMPLE ADDITIVE WEIGHTING (SAW)</h2><br>";


// Nilai Parameter untuk Setiap Alternatif sebelum Proses Normalisasi
echo "<h3>Tabel: Nilai Parameter untuk Setiap Alternatif sebelum Proses Normalisasi</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
echo "<td></td>";
for ($j = 0; $j < count($id_kriteria); $j++) {
    echo "<td>C" . ($j + 1) . "</td>";
}
echo "</tr>";
for ($i = 0; $i < count($matriks_sebelum_normalisasi); $i++) {
    echo "<tr>";
    echo "<td>A" . ($i + 1) . "</td>";
    for ($j = 0; $j < count($id_kriteria); $j++) {
        echo "<td>" . round($matriks_sebelum_normalisasi[$i][$j], 2) . "</td>";
    }
    echo "</tr>";
}
echo "</table><br><br>";


// Nilai Parameter untuk Setiap Alternatif setelah Proses Normalisasi
echo "<h3>Tabel: Nilai Parameter untuk Setiap Alternatif setelah Proses Normalisasi</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
echo "<td></td>";
for ($j = 0; $j < count($id_kriteria); $j++) {
    echo "<td>C" . ($j + 1) . "</td>";
}
echo "</tr>";
for ($i = 0; $i < count($matriks_setelah_normalisasi); $i++) {
    echo "<tr>";
    echo "<td>A" . ($i + 1) . "</td>";
    for ($j = 0; $j < count($id_kriteria); $j++) {
        echo "<td>" . round($matriks_setelah_normalisasi[$i][$j], 2) . "</td>";
    }
    echo "</tr>";
}
echo "</table><br><br>";


// Hasil Saran
echo "<h3>Tabel: Hasil Saran</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
for ($i = 0; $i < count($hasil_saran); $i++) {
    echo "<tr>";
    echo "<td>A" . ($i + 1) . "</td>";
    echo "<td>" . round($hasil_saran[$i][0], 3) . "</td>";
    echo "<td>" . $hasil_saran[$i][1] . "</td>";
    echo "</tr>";
}
echo "</table><br><br>";


// Hasil Saran (Dari Preferensi Terbesar)
echo "<h3>Tabel: Hasil Saran (Dari Preferensi Terbesar)</h3>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";
rsort($hasil_saran);
for ($i = 0; $i < count($hasil_saran); $i++) {
    $query = "SELECT NAMA_LAPTOP FROM master_laptop WHERE ID_LAPTOP = " . $hasil_saran[$i][1];
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($res)) {
        $hasil_saran[$i][2] = $row[0];
    }
    echo "<tr><td>" . round($hasil_saran[$i][0], 3) . "</td><td>" . $hasil_saran[$i][1] . "</td><td>" . $hasil_saran[$i][2] . "</td></tr>";
}
echo "</table><br><br>";

$_SESSION['array'] = $hasil_saran;

//header("Location: ../views/hasil.php");
exit();
