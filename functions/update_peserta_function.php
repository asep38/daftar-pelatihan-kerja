<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPeserta = $_POST['id_peserta'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $noTelpon = $_POST['no_telpon'];
    $tempatLahir = $_POST['tempat_lahir'];
    $tglLahir = $_POST['tgl_lahir'];
    $agama = $_POST['agama'];
    $nik = $_POST['nik'];
    $jeniskelamin = $_POST['jenis_kelamin'];

    $query = "UPDATE peserta SET nama=?, email=?, alamat=?, no_telpon=?, tempat_lahir=?, tgl_lahir=?, agama=?, nik=?,jenis_kelamin=? WHERE id_peserta=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssi", $nama, $email, $alamat, $noTelpon, $tempatLahir, $tglLahir, $agama, $nik, $jeniskelamin, $idPeserta);


    if ($stmt->execute()) {
        echo "Data Peserta Berhasil Diperbarui";
    } else {
        echo "Data Peserta Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Method not allowed";
}
