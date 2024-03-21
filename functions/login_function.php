<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();

require_once('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $password = $_POST["password"];

    $sql_peserta = "SELECT * FROM peserta WHERE nama = '$nama'";
    $result_peserta = $conn->query($sql_peserta);

    $sql_admin = "SELECT * FROM admin WHERE nama = '$nama'";
    $result_admin = $conn->query($sql_admin);

    if ($result_peserta->num_rows > 0) {
        $row = $result_peserta->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['nama'] = $nama;
            $_SESSION['role'] = $row['role'];
            setcookie('login_success', 'true', time() + 300, '/');
            header("Location: /daftar-pelatihan-kerja/");
            exit();
        }
    }

    if ($result_admin->num_rows > 0) {
        $row = $result_admin->fetch_assoc();
        if ($password === $row["password"]) {
            $_SESSION['logged_in'] = true;
            $_SESSION['nama'] = $nama;
            $_SESSION['role'] = $row['role'];
            setcookie('login_success', 'true', time() + 300, '/');
            header("Location: /daftar-pelatihan-kerja/dashboard.php");
            exit();
        }
    }
    setcookie('login_filed', 'true', time() + 300, '/');
    header("Location: /daftar-pelatihan-kerja/login.php");
    exit();
} else {
    echo "<script>alert('Method not allowed.');</script>";
}

$conn->close();
