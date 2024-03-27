<?php

require_once('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPeserta = $_POST['id-peserta'];
    $idPelatihan = $_POST['id-pelatihan'];
    $nilai = $_POST['nilai-peserta'];

    $sql = "INSERT INTO nilai (id_peserta, id_pelatihan, nilai) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("iii", $idPeserta, $idPelatihan, $nilai);

    if ($stmt->execute()) {
        echo "Nilai berhasil ditambahkan.";
    } else {
        echo "Terjadi kesalahan";
    }

    $stmt->close();
} else {
    echo "Metode request tidak valid.";
}

$conn->close();
