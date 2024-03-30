<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once ('../config/koneksi.php');

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
    $idjurusan = $_POST["idjurusan"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO peserta (`nik`, `id_jurusan`, `nama`, `email`, `alamat`, `telepon`, `agama`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`) VALUES 
                                ('$nik', '$idjurusan', '$nama', '$email', '$alamat', '$no_telpon', '$agama', '$tempat_lahir', '$tgl_lahir', '$jenis_kelamin')";

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
