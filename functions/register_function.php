<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once('../config/koneksi.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = "";
    $kejuruan = "";
    $sifat = "";
    $tingkat_pelatihan = "";
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

    $sql = "INSERT INTO peserta (nis, kejuruan, sifat, tingkat_pelatihan, nik, id_jurusan, nama, email, alamat, telepon, agama, tempat_lahir, tgl_lahir, jenis_kelamin, provinsi, `kab/kota`, pendidikan) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssisssssssssss", $nis, $kejuruan, $sifat, $tingkat_pelatihan, $nik, $idjurusan, $nama, $email, $alamat, $no_telpon, $agama, $tempat_lahir, $tgl_lahir, $jenis_kelamin, $provinsi, $kab_kota, $pendidikan);

        if ($stmt->execute()) {
            setcookie('registration_success', 'true', time() + 300, '/');
            header("Location: /daftar-pelatihan-kerja/login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "<script>alert('Method not allowed.');</script>";
}

$conn->close();
