<!DOCTYPE html>
<html lang="en">
<?php require "includes/header.php";

require_once ('./config/koneksi.php');
$queryPeserta = "SELECT * FROM `peserta`";
$queryjurusan = "SELECT * FROM `jurusan`";

$result_peserta = $conn->query($queryPeserta);
$result_jurusan = $conn->query($queryjurusan);

$jumlah_peserta = mysqli_num_rows($result_peserta);
$jumlah_jurusan = mysqli_num_rows($result_jurusan);
?>


<body class="sb-nav-fixed">
    <?php require "includes/navbar.php"; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php require "includes/sidebar.php"; ?>
        </div>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Jumlah Jurusan</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <?php echo $jumlah_jurusan; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Jumlah Peserta</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <?php echo $jumlah_peserta; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    <?php require "includes/footer.php"; ?>
    <?php require "includes/js.php"; ?>
</body>

</html>