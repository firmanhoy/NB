<?php
include('function.php');

// Ambil data JSON untuk training
$filePath = 'C:\\xampp_7\\htdocs\\NaiveBayes\\training.json'; 
$data = ambilDataJSON($filePath);

// Variabel untuk menyimpan hasil
$persebaranData = [];
$atributPilihan = isset($_POST['atribut']) ? $_POST['atribut'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $atributPilihan !== '') {
    $persebaranData = hitungPersebaran($data, $atributPilihan);
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
        <h1 class="text-center mb-4">Rincian Persebaran Atribut</h1>

        <!-- Form untuk memilih atribut -->
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="atribut" class="form-label">Pilih Atribut:</label>
                <select class="form-select" id="atribut" name="atribut" required>
                    <option value="" disabled selected>Pilih Atribut</option>
                    <option value="Umur" <?= $atributPilihan == 'Umur' ? 'selected' : '' ?>>Umur</option>
                    <option value="Jenis Kelamin" <?= $atributPilihan == 'Jenis Kelamin' ? 'selected' : '' ?>>Jenis Kelamin</option>
                    <option value="Kelas" <?= $atributPilihan == 'Kelas' ? 'selected' : '' ?>>Kelas</option>
                    <option value="Tempat Tinggal" <?= $atributPilihan == 'Tempat Tinggal' ? 'selected' : '' ?>>Tempat Tinggal</option>
                    <option value="Gunakan HP" <?= $atributPilihan == 'Gunakan HP' ? 'selected' : '' ?>>Gunakan HP</option>
                    <option value="Gunakan Laptop" <?= $atributPilihan == 'Gunakan Laptop' ? 'selected' : '' ?>>Gunakan Laptop</option>
                    <option value="Akses Internet" <?= $atributPilihan == 'Akses Internet' ? 'selected' : '' ?>>Akses Internet</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Lihat Persebaran</button>
        </form>

        <?php if (!empty($persebaranData)): ?>
            <!-- Tampilkan hasil persebaran -->
            <h3>Persebaran untuk Atribut: <strong><?= htmlspecialchars($atributPilihan) ?></strong></h3>
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
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <div class="alert alert-warning">Tidak ada data untuk atribut yang dipilih.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
