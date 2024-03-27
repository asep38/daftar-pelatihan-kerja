<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}

require_once ('./config/koneksi.php');
$query = "SELECT pelatihan.id_pelatihan, jurusan.nama_jurusan, pelatihan.tanggal_mulai, pelatihan.tanggal_selesai
FROM pelatihan
JOIN jurusan ON pelatihan.id_jurusan = jurusan.id_jurusan
";

$result = $conn->query($query);
?>

<style>
    .pointer {
        cursor: pointer;
        text-decoration: none;
    }

    body.modal-open {
        overflow: hidden;
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.15s linear;
    }

    .modal-backdrop.show {
        opacity: 1;
    }
</style>

<main>


    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Peserta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                Pilih Pelatihan dan jadwal
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Table Peserta
            </div>
            <div class="card-body">
                <form role="form" action="detailabsensi.php" method="get" name="postform" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select id="kelas" class="form-control" name="kelas">
                            <?php

                            while ($data = mysqli_fetch_array($result)) {
                                echo "<option value='$data[0]' > $data[1] </option>";
                            }

                            ?>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="jadwal">Jadwal</label>
                        <select id="jadwal" class="form-control" name="jadwal">
                            <option selected>Minggu 1</option>
                            <option>Minggu 2</option>
                            <option>Minggu 3</option>
                            <option>Minggu 4</option>
                            <option>Minggu 5</option>
                            <option>Minggu 6</option>
                            <option>Minggu 7</option>
                            <option>Minggu 8</option>
                            <option>Minggu 9</option>
                            <option>Minggu 10</option>
                            <option>Minggu 11</option>
                            <option>Minggu 12</option>
                            <option>Minggu 13</option>
                            <option>Minggu 14</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Lihat</button>
                </form>
            </div>
        </div>

    </div>
</main>
<script>

</script>