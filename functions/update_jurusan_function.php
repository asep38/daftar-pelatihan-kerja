<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once ('../config/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Handle GET request to fetch jurusan data
    $idJurusan = $_GET['id'];
    $query = "SELECT * FROM jurusan WHERE id_jurusan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $idJurusan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Jurusan not found"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request to update jurusan data
    if (isset($_POST['id_jurusan']) && isset($_POST['jurusan'])) {
        $idJurusan = $_POST['id_jurusan'];
        $namaJurusan = $_POST['jurusan'];

        $query = "UPDATE jurusan SET nama_jurusan = ? WHERE id_jurusan = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $namaJurusan, $idJurusan);
        if ($stmt->execute()) {
            echo "Jurusan updated successfully";
        } else {
            echo "Error updating jurusan";
        }
    } else {
        echo "Invalid input";
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}