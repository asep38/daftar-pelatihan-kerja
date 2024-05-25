<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $no_telpon = $_POST["no_telpon"];
    $alamat = $_POST["alamat"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $agama = $_POST["agama"];
    $tgl_lahir = $_POST["tgl_lahir"];
    $tempat_lahir = $_POST["tempat_lahir"];
    $nik = $_POST["nik"];
    $idjurusan = $_POST["idjurusan"];
    $provinsi = $_POST["provinsi"];
    $kab_kota = $_POST["kab_kota"];
    $pendidikan = $_POST["pendidikan"];
    $tingkat_pelatihan = $_POST["tingkat_pelatihan"];
    $sifat = $_POST["sifat"];
    $kejuruan = $_POST["kejuruan"];

    $kode_kab = '052';

    $tahun = date("Y");

    $query_urut = "SELECT COUNT(*) AS jumlah FROM peserta WHERE id_jurusan = ?";
    $stmt_urut = $conn->prepare($query_urut);
    $stmt_urut->bind_param("i", $idjurusan);
    $stmt_urut->execute();
    $result_urut = $stmt_urut->get_result();
    $row_urut = $result_urut->fetch_assoc();
    $nomor_urut = str_pad($row_urut['jumlah'] + 1, 4, '0', STR_PAD_LEFT);

    $nis = $nomor_urut . $kode_kab . $tingkat_pelatihan . $kejuruan . $sifat . $tahun;

    $stmt_urut->close();

    $sql = "INSERT INTO peserta (`nik`, `id_jurusan`, `nama`, `email`, `alamat`, `telepon`, `agama`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `provinsi`, `kab/kota`, `pendidikan`, `nis`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssssssssss", $nik, $idjurusan, $nama, $email, $alamat, $no_telpon, $agama, $tempat_lahir, $tgl_lahir, $jenis_kelamin, $provinsi, $kab_kota, $pendidikan, $nis);

    if ($stmt->execute()) {
        setcookie('registration_success', 'true', time() + 300, '/');
        header("Location: /daftar-pelatihan-kerja/login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "<script>alert('Method not allowed.');</script>";
}

$conn->close();
