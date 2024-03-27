<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once ('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idJurusan = $_POST['id_jurusan'];
    $nama_jurusan = $_POST['jurusan'];


    $query = "UPDATE jurusan SET nama_jurusan=? WHERE id_jurusan=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nama_jurusan, $idJurusan);

    if ($stmt->execute()) {
        echo "Data Pelatihan Berhasil Diperbarui";
    } else {
        echo "Data Peserta Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Method not allowed";
}
