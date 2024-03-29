<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$idPelatihan = $_GET['id_pelatihan'];


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}

require_once ('./config/koneksi.php');
$query = "SELECT * FROM peserta WHERE id_jurusan = $idPelatihan
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
                <table id="datatablesSimple">
                    <?php if ($result->num_rows > 0) { ?>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                    <?php } ?>
                    <tbody>
                        <?php
                        $i = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $i++; ?>.
                                    </td>
                                    <td>
                                        <?php echo $row["nama"]; ?>
                                    </td>

                                    <td>
                                        <label class="btn btn-success"><input type="radio"
                                                name="<?= 'ket' . $data["id_peserta"]; ?>"
                                                id="<?php echo 'opsi1' . $row["id_peserta"]; ?>" value="hadir">Hadir</label>

                                        <label class="btn btn-danger"><input type="radio"
                                                name="<?= 'ket' . $data["id_peserta"]; ?>"
                                                id="<?php echo 'opsi1' . $row["id_peserta"]; ?>" value="absen">Absen</label>

                                        <label class="btn btn-warning"><input type="radio"
                                                name="<?= 'ket' . $data["id_peserta"]; ?>"
                                                id="<?php echo 'opsi1' . $row["id_peserta"]; ?>" value="sakit">Sakit</label>

                                        <label class="btn btn-primary"><input type="radio"
                                                name="<?= 'ket' . $data["id_peserta"]; ?>"
                                                id="<?php echo 'opsi1' . $row["id_peserta"]; ?>" value="izin">Izin</label>
                                    </td>


                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan='5'>No data found</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</main>
<script>

</script>