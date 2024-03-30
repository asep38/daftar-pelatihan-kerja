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
        <h1 class="mt-4">Daftar Minggu</h1>
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
                Data Tabel Minggu
            </div>
            <div class="card-body">
                <form role="form" action="simpanabsensi.php?id=<?php echo $_GET['kelas']; ?>" method="post"
                    name="postform" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>ID Peserta</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                $id_jurusan = $_GET['kelas'];
                                $sql = "SELECT * FROM peserta WHERE id_jurusan='$id_jurusan'";
                                $query = mysqli_query($koneksi, $sql);
                                $i = 1;
                                while ($data = mysqli_fetch_array($query)) {
                                    $idPeserta = $data["id_peserta"];
                                    $nama = $data["nama"];
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $i++; ?>
                                        </td>

                                        <td>
                                            <?= $npm; ?>
                                        </td>
                                        <td>
                                            <?= $nama; ?>
                                        </td>
                                        <td>
                                            <label class="radio-inline"><input type="radio"
                                                    name="<?= 'ket' . $data["id_peserta"]; ?>"
                                                    id="<?php echo 'opsi1' . $idPeserta; ?>" value="hadir">Hadir</label>
                                            <label class="radio-inline"><input type="radio"
                                                    name="<?= 'ket' . $data["id_peserta"]; ?>"
                                                    id="<?php echo 'opsi1' . $idPeserta; ?>" value="absen">Absen</label>
                                            <label class="radio-inline"><input type="radio"
                                                    name="<?= 'ket' . $data["id_peserta"]; ?>"
                                                    id="<?php echo 'opsi1' . $idPeserta; ?>" value="sakit">Sakit</label>
                                            <label class="radio-inline"><input type="radio"
                                                    name="<?= 'ket' . $data["id_peserta"]; ?>"
                                                    id="<?php echo 'opsi1' . $idPeserta; ?>" value="izin">Izin</label>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 col-md-2 offset-10">Simpan Data</button>
                </form>
            </div>
        </div>

    </div>
</main>
<script>

</script>