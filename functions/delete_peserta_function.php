<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_peserta = $_GET['id'];
    $query = "DELETE FROM peserta WHERE id_peserta = $id_peserta";

    if ($conn->query($query) === TRUE) {
        session_start();
        $_SESSION['success_message'] = "Data peserta berhasil dihapus.";
        header("Location: /daftar-pelatihan-kerja/dashboard.php?page=peserta");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request";
}
