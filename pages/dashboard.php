<!DOCTYPE html>
<html lang="en">
<?php require "includes/header.php"; ?>

<body class="sb-nav-fixed">
    <?php require "includes/navbar.php"; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php require "includes/sidebar.php"; ?>
        </div>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid px-4">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Jumlah Pelatihan</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Jumlah Peserta</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
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