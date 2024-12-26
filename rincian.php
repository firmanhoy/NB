<?php
require_once 'function.php';
$filePath = 'training.json';
$datas = ambilDataJSON($filePath);

// Fungsi untuk menghitung frekuensi kategori
function hitungKategori($data, $atribut) {
    $hasil = [];
    foreach ($data as $item) {
        $nilai = $item[$atribut];
        if (!isset($hasil[$nilai])) {
            $hasil[$nilai] = 0;
        }
        $hasil[$nilai]++;
    }
    return $hasil;
}

// Menghitung frekuensi untuk setiap atribut
$rincian = [
    'Umur' => hitungKategori($datas, 'Umur'),
    'Jenis Kelamin' => hitungKategori($datas, 'Jenis Kelamin'),
    'Kelas' => hitungKategori($datas, 'Kelas'),
    'Tempat Tinggal' => hitungKategori($datas, 'Tempat Tinggal'),
    'Gunakan HP' => hitungKategori($datas, 'Gunakan HP'),
    'Gunakan Laptop' => hitungKategori($datas, 'Gunakan Laptop'),
    'Akses Internet' => hitungKategori($datas, 'Akses Internet'),
];
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Data Training</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
        }
        .table-container thead {
            position: sticky;
            top: 0;
            background-color: #343a40;
            color: #fff;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="fw-bold mb-4 text-center">Rincian Data Training</h1>
        <div class="row">
            <?php foreach ($rincian as $atribut => $kategori): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="card-title mb-0"><?= $atribut ?></h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kategori as $k => $jumlah): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($k) ?></td>
                                            <td><?= $jumlah ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
