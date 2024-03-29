<?php
$idPelatihan = $_GET['id_pelatihan'];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}

require_once('./config/koneksi.php');

$query = "SELECT * FROM peserta WHERE id_jurusan = $idPelatihan";
$result = $conn->query($query);
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Peserta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <a href="#" class="btn btn-primary">Rekap Absen</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Table Peserta
            </div>
            <div class="card-body">
                <form action="./functions/input_absen_function.php" method="post">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?>.</td>
                                        <td><?php echo $row["nama"]; ?></td>
                                        <td>
                                            <input type="hidden" name="id_peserta" value="<?php echo $row["id_peserta"]; ?>">
                                            <input type="hidden" name="id_pelatihan" value="<?php echo $idPelatihan; ?>">
                                            <label class="btn btn-success">
                                                <input type="radio" name="keterangan[<?php echo $row["id_peserta"]; ?>]" value="hadir"> Hadir
                                            </label>
                                            <label class="btn btn-danger">
                                                <input type="radio" name="keterangan[<?php echo $row["id_peserta"]; ?>]" value="absen"> Absen
                                            </label>
                                            <label class="btn btn-warning">
                                                <input type="radio" name="keterangan[<?php echo $row["id_peserta"]; ?>]" value="sakit"> Sakit
                                            </label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="keterangan[<?php echo $row["id_peserta"]; ?>]" value="izin"> Izin
                                            </label>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan='3'>No data found</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</main>