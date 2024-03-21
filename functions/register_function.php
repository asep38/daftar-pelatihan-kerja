<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $no_telpon = $_POST["no_telpon"];
    $alamat = $_POST["alamat"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $agama = $_POST["agama"];
    $tgl_lahir = $_POST["tgl_lahir"];
    $tempat_lahir = $_POST["tempat_lahir"];
    $nik = $_POST["nik"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO peserta (nama, email, password, no_telpon, alamat, jenis_kelamin, agama, tgl_lahir, tempat_lahir, nik, role) VALUES ('$nama', '$email', '$hashed_password', '$no_telpon', '$alamat', '$jenis_kelamin', '$agama', '$tgl_lahir', '$tempat_lahir', '$nik', 'peserta')";

    if ($conn->query($sql) === TRUE) {
        setcookie('registration_success', 'true', time() + 300, '/');
        header("Location: /daftar-pelatihan-kerja/login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "<script>alert('Method not allowed.');</script>";
}

$conn->close();
