<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once ('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jurusan = $_POST['jurusan'];


    $query = "INSERT INTO `jurusan`(`nama_jurusan`) VALUES ('$jurusan')";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data jurusan berhasil ditambahkan');</script>";
        echo "<script>window.location.href = '/daftar-pelatihan-kerja/dashboard.php?page=kejuruan';</script>";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}
