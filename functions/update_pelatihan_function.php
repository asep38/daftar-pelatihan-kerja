<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPelatihan = $_POST['id_pelatihan'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $tempat = $_POST['tempat'];

    $query = "UPDATE pelatihan SET nama=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=?, tempat=? WHERE id_pelatihan=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nama, $deskripsi, $tanggal_mulai, $tanggal_selesai, $tempat, $idPelatihan);

    if ($stmt->execute()) {
        echo "Data Pelatihan Berhasil Diperbarui";
    } else {
        echo "Data Peserta Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Method not allowed";
}
