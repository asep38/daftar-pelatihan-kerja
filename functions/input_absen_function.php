<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$keterangan = $_POST['keterangan'];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/koneksi.php');

foreach ($keterangan as $id_peserta => $status) {
    $query = $conn->prepare("INSERT INTO absensi (id_peserta, id_pelatihan, jadwal, keterangan) VALUES (?, ?, NOW(), ?)");
    $query->bind_param("iis", $id_peserta, $_POST['id_pelatihan'], $status);
    $query->execute();
}

$_SESSION['success_message'] = "Data absen berhasil disimpan.";

header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
