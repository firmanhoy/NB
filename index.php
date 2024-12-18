<?php
require_once 'function.php';
$filePath = 'C:\xampp_7\htdocs\NaiveBayes\training.json';
$datas = ambilDataJSON($filePath);
?>

<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Naive Bayes</title>
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
    </style>
</head>
<body>
	<div class="table-responsive small">
    <div class="container">
      <div class="row">
        <div class="col-md-8 ">
          <h3>Data Training</h3>
          <div class="table-container">
            <table class="table table-striped table-sm mb-0">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Umur</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Gunakan HP</th>
                        <th scope="col">Gunakan Laptop</th>
                        <th scope="col">Akses Internet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0 ?>
                    <?php foreach ($datas as $data): ?>
                        <?php $i++; ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $data["Umur"]; ?></td>
                            <td><?= $data["Jenis Kelamin"]; ?></td>
                            <td><?= $data["Kelas"]; ?></td>
                            <td><?= $data["Gunakan HP"]; ?></td>
                            <td><?= $data["Gunakan Laptop"]; ?></td>
                            <td><?= $data["Akses Internet"]; ?></td>
                        </tr>
                        
                    <?php endforeach ?>
                </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-4 mt-5 text-center">
          <h1 class="fw-bold mt-5">Total Data</h1>
          <h3 class="fw-bold mt-3"><?= $i;?></h3>
        </div>
        <body>
        <div class="container mt-5">
            <h2 class="mb-4 text-center">Form Prediksi Akses Internet</h2>
            <form action="result.php" method="POST" class="row g-3">
            <!-- Dropdown untuk Umur -->
            <div class="col-md-6">
                <label for="umur" class="form-label">Umur</label>
                <select class="form-select" id="umur" name="umur" required>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                </select>
            </div>

            <!-- Dropdown untuk Kelas -->
            <div class="col-md-6">
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-select" id="kelas" name="kelas" required>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>

            <!-- Dropdown untuk Jenis Kelamin -->
            <div class="col-md-6">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <!-- Dropdown untuk Tempat Tinggal -->
            <div class="col-md-6">
                <label for="tempat_tinggal" class="form-label">Tempat Tinggal</label>
                <select class="form-select" id="tempat_tinggal" name="tempat_tinggal" required>
                    <option value="Perkotaan">Perkotaan</option>
                    <option value="Pedesaan">Pedesaan</option>
                </select>
            </div>

            <!-- Dropdown untuk Gunakan HP -->
            <div class="col-md-6">
                <label for="gunakan_hp" class="form-label">Gunakan HP</label>
                <select class="form-select" id="gunakan_hp" name="gunakan_hp" required>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <!-- Dropdown untuk Gunakan Laptop -->
            <div class="col-md-6">
                <label for="gunakan_laptop" class="form-label">Gunakan Laptop</label>
                <select class="form-select" id="gunakan_laptop" name="gunakan_laptop" required>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <!-- Tombol Kirim -->
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Prediksi</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>