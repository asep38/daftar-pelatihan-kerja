<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once ('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idjurusan = $_POST['idjurusan'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $tempat = $_POST['tempat'];

    $query = "INSERT INTO pelatihan (`id_jurusan`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `tempat`) VALUES 
    ('$idjurusan', '$deskripsi', '$tanggal_mulai', '$tanggal_selesai', '$tempat')";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data pelatihan berhasil ditambahkan');</script>";
        echo "<script>window.location.href = '/daftar-pelatihan-kerja/dashboard.php?page=pelatihan';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}
