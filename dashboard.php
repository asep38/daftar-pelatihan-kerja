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