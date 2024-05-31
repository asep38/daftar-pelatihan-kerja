<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once ('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_jurusan = $_GET['id'];
    $query = "DELETE FROM `jurusan` WHERE id_jurusan = $id_jurusan";

    if ($conn->query($query) === TRUE) {
        session_start();
        $_SESSION['success_message'] = "Data jurusan berhasil dihapus.";
        header("Location: /daftar-pelatihan-kerja/dashboard.php?page=kejuruan");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request";
}
