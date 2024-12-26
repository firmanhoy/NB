<?php
include('function.php');

// Ambil data JSON untuk training
$filePath = 'training.json'; 
$data = ambilDataJSON($filePath);

// Atribut yang akan dihitung persebarannya
$atributList = [
    'Umur',
    'Jenis Kelamin',
    'Kelas',
    'Tempat Tinggal',
    'Gunakan HP',
    'Gunakan Laptop',
    'Akses Internet'
];

// Hitung persebaran untuk setiap atribut
$hasilPersebaran = [];
foreach ($atributList as $atribut) {
    $hasilPersebaran[$atribut] = hitungPersebaran($data, $atribut);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Persebaran Atribut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body data-bs-theme="dark">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Rincian Persebaran Semua Atribut Data Training</h1>

        <?php foreach ($hasilPersebaran as $atribut => $persebaranData): ?>
            <h3>Persebaran untuk Atribut: <strong><?= htmlspecialchars($atribut) ?></strong></h3>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Nilai</th>
                        <th>Frekuensi</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($persebaranData as $nilai => $detail): ?>
                        <tr>
                            <td><?= htmlspecialchars($nilai) ?></td>
                            <td><?= $detail['count'] ?></td>
                            <td><?= $detail['percentage'] ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
