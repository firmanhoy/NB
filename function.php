<?php

function ambilDataJSON($filePath) {
    if (file_exists($filePath)) {
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);
        if ($data !== null) {
            return $data;
        } else {
            return ["error" => "Gagal decode JSON"];
        }
    } else {
        return ["error" => "File tidak ditemukan"];
    }
}

function hitungPrior($data) {
    $jumlah_data = count($data);
    $jumlah_akses_internet_ya = 0;
    $jumlah_akses_internet_tidak = 0;

    foreach ($data as $row) {
        if ($row["Akses Internet"] == "Ya") {
            $jumlah_akses_internet_ya++;
        } else {
            $jumlah_akses_internet_tidak++;
        }
    }

    $prior_ya = $jumlah_akses_internet_ya / $jumlah_data;
    $prior_tidak = $jumlah_akses_internet_tidak / $jumlah_data;

    return [
        'Ya' => $prior_ya,
        'Tidak' => $prior_tidak
    ];
}

function hitungLikelihood($data, $fitur, $nilai_fitur, $kelas) {
    $total_kelas = 0;
    $fitur_kelas = 0;

    foreach ($data as $row) {
        if ($row["Akses Internet"] == $kelas) {
            $total_kelas++;
            
            if (in_array($row[$fitur], $nilai_fitur)) {
                $fitur_kelas++;
            }
        }
    }

    if ($total_kelas == 0) {
        return 0;
    }

    return $fitur_kelas / $total_kelas;
}

function hitungPosterior($data, $fitur_data) {
    $prior = hitungPrior($data);

    $likelihood_ya = $prior['Ya'];
    $likelihood_tidak = $prior['Tidak'];

    foreach ($fitur_data as $fitur => $nilai) {
        $likelihood_ya *= hitungLikelihood($data, $fitur, [$nilai], 'Ya');
        $likelihood_tidak *= hitungLikelihood($data, $fitur, [$nilai], 'Tidak');
    }

    $posterior = [
        'Ya' => $likelihood_ya,
        'Tidak' => $likelihood_tidak
    ];

    return $posterior;
}

function prediksiAksesInternet($posterior) {
    return $posterior['Ya'] > $posterior['Tidak'] ? 'Ya' : 'Tidak';
}

function hitungPersebaran($data, $atribut) {
    $frekuensi = [];
    $total = count($data);

    // Hitung frekuensi tiap nilai dalam atribut
    foreach ($data as $row) {
        if (isset($row[$atribut])) {
            $nilai = $row[$atribut];
            if (!isset($frekuensi[$nilai])) {
                $frekuensi[$nilai] = 0;
            }
            $frekuensi[$nilai]++;
        }
    }

    // Hitung persentase
    foreach ($frekuensi as $nilai => $count) {
        $frekuensi[$nilai] = [
            'count' => $count,
            'percentage' => round(($count / $total) * 100, 2)
        ];
    }

    return $frekuensi;
}
?>

