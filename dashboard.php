<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /daftar-pelatihan-kerja/login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: /daftar-pelatihan-kerja/");
    exit();
}

require_once ('./config/koneksi.php');
$queryPeserta = "SELECT * FROM `peserta`";
$queryjurusan = "SELECT * FROM `jurusan`";

$result_peserta = $conn->query($queryPeserta);
$result_jurusan = $conn->query($queryjurusan);

$jumlah_peserta = mysqli_num_rows($result_peserta);
$jumlah_jurusan = mysqli_num_rows($result_jurusan);
?>

<!DOCTYPE html>
<html lang="en">
<?php require "includes/header.php"; ?>

<body class="sb-nav-fixed">
    <?php require "includes/navbar.php"; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php require "includes/sidebar.php"; ?>
        </div>

        <div id="layoutSidenav_content">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ($page == 'peserta') {
                    require "pages/peserta.php";
                } elseif ($page == 'pelatihan') {
                    require "pages/pelatihan.php";
                } elseif ($page == 'kejuruan') {
                    require "pages/kejuruan.php";
                } elseif ($page == 'nilaipilihpelatihan') {
                    require "pages/nilai-pilih-pelatihan.php";
                } elseif ($page == 'nilaipilihpeserta') {
                    require "pages/nilai-pilih-peserta.php";
                } elseif ($page == 'absensi') {
                    require "pages/absensi.php";
                } elseif ($page == 'absensidetail') {
                    require "pages/absensi-detail.php";
                } elseif ($page == 'absensipilihminggu') {
                    require "pages/absensi-pilih-minggu.php";
                } elseif ($page == 'absensiinput') {
                    require "pages/absensi-input.php";
                } elseif ($page == 'cetakpeserta') {
                    require "pages/cetak-peserta.php";
                } elseif ($page == 'rekapnilai') {
                    require "pages/rekap-nilai.php";
                } elseif ($page == 'sertifikat') {
                    require "pages/cetak-sertifikat.php";
                } elseif ($page == 'instruktur') {
                    require "pages/instruktur.php";
                } elseif ($page == 'dashboard') {
                    require "pages/dashboard.php";
                } else {
                    echo "Halaman tidak ditemukan.";
                }
            } else {
                // require "";
            }
            ?>



            <?php require "includes/footer.php"; ?>
        </div>
    </div>
    <?php require "includes/js.php"; ?>
    <script>
        const loginsuccess = document.cookie.split(';').some((item) => item.trim().startsWith('login_success='));
        if (loginsuccess) {
            alert('Login Success, Selamat datang ' + '<?php echo $_SESSION['nama']; ?>');
        }
        document.cookie = 'login_success=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    </script>
</body>

</html>