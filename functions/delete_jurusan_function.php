<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once ('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset ($_GET['id'])) {
    $id_pelatihan = $_GET['id'];
    $query = "DELETE FROM pelatihan WHERE id_pelatihan = $id_pelatihan";

    if ($conn->query($query) === TRUE) {
        session_start();
        $_SESSION['success_message'] = "Data peserta berhasil dihapus.";
        header("Location: /daftar-pelatihan-kerja/dashboard.php?page=pelatihan");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request";
}
