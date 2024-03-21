<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once('../config/koneksi.php');

if (isset($_GET['id'])) {
    $idPeserta = $_GET['id'];

    $query = "SELECT * FROM peserta WHERE id_peserta = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idPeserta);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(array());
    }

    $stmt->close();
} else {
    echo json_encode(array('error' => 'Parameter "id" tidak ditemukan dalam permintaan.'));
}

$conn->close();
