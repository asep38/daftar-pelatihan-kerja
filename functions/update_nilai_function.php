<?php
require_once('../config/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_peserta'], $_POST['nilai_peserta'])) {
    $idPeserta = $_POST['id_peserta'];
    $nilai = $_POST['nilai_peserta'];

    $query = "UPDATE nilai SET nilai = $nilai WHERE id_peserta = $idPeserta";

    if ($conn->query($query) === TRUE) {
        echo "Nilai berhasil diperbarui.";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
} else {
    echo "Permintaan tidak valid.";
}
