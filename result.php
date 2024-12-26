<?php
include('function.php');

// Ambil data JSON untuk training dan testing
$filePath = 'training.json'; 
$testPath = 'testing.json'; 
$data = ambilDataJSON($filePath);
$dataTest = ambilDataJSON($testPath);

// Variabel untuk menampung hasil
$prediksi = '';
$posteriorYa = 0;
$posteriorTidak = 0;
$atributValues = [];
$presentasiYa = 0;
$presentasiTidak = 0;
$jumlahBenar = 0;
$jumlahSalah = 0;

// Evaluasi data dari tabel testing
foreach ($dataTest as $row) {
    $prediksiNaive = $row['Hasil Klasifikasi (Naive Bayes)'];
    $prediksiUser = $row['Akses Internet (Prediksi)'];

    if ($prediksiNaive === $prediksiUser) {
        $jumlahBenar++;
    } else {
        $jumlahSalah++;
    }
}

// Proses data input user (jika ada)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai atribut dari form
    $umur = $_POST['umur'];
    $jenisKelamin = $_POST['jenis_kelamin'];
    $kelas = $_POST['kelas'];
    $tempatTinggal = $_POST['tempat_tinggal'];
    $gunakanHP = $_POST['gunakan_hp'];
    $gunakanLaptop = $_POST['gunakan_laptop'];
    $prediksiUser = $_POST['prediksi_user'];

    // Masukkan atribut tersebut dalam array untuk perhitungan posterior
    $atributValues = [
        'Umur' => $umur,
        'Jenis Kelamin' => $jenisKelamin,
        'Kelas' => $kelas,
        'Tempat Tinggal' => $tempatTinggal,
        'Gunakan HP' => $gunakanHP,
        'Gunakan Laptop' => $gunakanLaptop
    ];

    // Hitung posterior probability berdasarkan atribut
    $posterior = hitungPosterior($data, $atributValues);

    // Simpan nilai posterior "Ya" dan "Tidak"
    $posteriorYa = isset($posterior['Ya']) ? $posterior['Ya'] : 0;
    $posteriorTidak = isset($posterior['Tidak']) ? $posterior['Tidak'] : 0;

    // Hitung persentase tebakan "Ya" dan "Tidak"
    $totalPosterior = $posteriorYa + $posteriorTidak;
    if ($totalPosterior > 0) {
        $presentasiYa = round(($posteriorYa / $totalPosterior) * 100, 2);
        $presentasiTidak = round(($posteriorTidak / $totalPosterior) * 100, 2);
    }

    // Prediksi Akses Internet berdasarkan nilai posterior
    $prediksi = $posteriorYa > $posteriorTidak ? 'Ya' : 'Tidak';

    // Evaluasi prediksi user
    if ($prediksi === $prediksiUser) {
        $jumlahBenar++;
    } else {
        $jumlahSalah++;
    }
}

// Total Data
$totalData = $jumlahBenar + $jumlahSalah;

// Akurasi
$akurasi = $totalData > 0 ? round(($jumlahBenar / $totalData) * 100, 2) : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediksi Akses Internet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body data-bs-theme="dark">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Prediksi Akses Internet Berdasarkan Data Pengguna</h1>
        
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <!-- Tampilkan hasil prediksi -->
            <div class="alert alert-info">
                <h4>Hasil Naive Bayes:</h4>
                <p><strong>Akses Internet: </strong> <?= $prediksi ?></p>
            </div>

            <!-- Tampilkan persentase tebakan -->
            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-success">
                        <h4>Persentase Tebakan:</h4>
                        <p><strong>Ya: </strong> <?= $presentasiYa ?>%</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-warning">
                        <h4>Persentase Tebakan:</h4>
                        <p><strong>Tidak: </strong> <?= $presentasiTidak ?>%</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Evaluasi Hasil -->
        <div class="row text-center mt-5">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Banyak Data BENAR</div>
                    <div class="card-body">
                        <h5 class="card-title fs-1"><?= $jumlahBenar ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Banyak Data SALAH</div>
                    <div class="card-body">
                        <h5 class="card-title fs-1"><?= $jumlahSalah ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Akurasi Naive Bayes</div>
                    <div class="card-body">
                        <h5 class="card-title fs-1"><?= $akurasi ?>%</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tampilkan Data Testing -->
        <h5 class="mt-5">Data Testing:</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Umur</th>
                    <th>Jenis Kelamin</th>
                    <th>Kelas</th>
                    <th>Tempat Tinggal</th>
                    <th>Gunakan HP</th>
                    <th>Gunakan Laptop</th>
                    <th>Akses Internet (Prediksi)</th>
                    <th>Hasil Klasifikasi (Naive Bayes)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataTest as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $row['Umur'] ?></td>
                        <td><?= $row['Jenis Kelamin'] ?></td>
                        <td><?= $row['Kelas'] ?></td>
                        <td><?= $row['Tempat Tinggal'] ?></td>
                        <td><?= $row['Gunakan HP'] ?></td>
                        <td><?= $row['Gunakan Laptop'] ?></td>
                        <td><?= $row['Akses Internet (Prediksi)'] ?></td>
                        <td><?= $row['Hasil Klasifikasi (Naive Bayes)'] ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                    <tr>
                        <td><?= count($dataTest) + 1 ?></td>
                        <td><?= $umur ?></td>
                        <td><?= $jenisKelamin ?></td>
                        <td><?= $kelas ?></td>
                        <td><?= $tempatTinggal ?></td>
                        <td><?= $gunakanHP ?></td>
                        <td><?= $gunakanLaptop ?></td>
                        <td><?= $prediksiUser ?></td>
                        <td><?= $prediksi ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-primary btn-md">Kembali</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
