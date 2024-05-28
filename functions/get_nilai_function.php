<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../config/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idPeserta = $_GET['id'];

    $query = "SELECT peserta.nama, nilai.nilai 
              FROM peserta 
              INNER JOIN nilai ON peserta.id_peserta = nilai.id_peserta 
              WHERE peserta.id_peserta = $idPeserta";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $nilai = $row['nilai'];

        $response = array(
            'id_peserta' => $idPeserta,
            'nama' => $nama,
            'nilai' => $nilai
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        echo "Data nilai tidak ditemukan";
    }
} else {
    echo "Permintaan tidak valid.";
}
