<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$pelatihan = $_GET['id_pelatihan'];

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
                <table id="datatablesSimple">
                    <?php if ($result->num_rows > 0) { ?>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php } ?>
                    <tbody>

                        <?php
                        $i = 1;
                        $minggu = array(
                            "hari 1",
                            "hari 2",
                            "hari 3",
                            "hari 4",
                            "hari 5",
                            "hari 6",
                            "hari 7",
                            "hari 8",
                            "hari 9",
                            "hari 10",
                            "hari 11",
                            "hari 12",
                            "hari 13",
                            "hari 14"
                        );

                        foreach ($minggu as $index => $item) {
                            $week_number = $index + 1; // Nomor minggu dimulai dari 1
                        
                            ?>
                            <tr>
                                <td>
                                    <?php echo $i++; ?>.
                                </td>
                                <td>
                                    <?php echo $item; ?>
                                </td>
                                <td>
                                    <a class="pointer me-2"
                                        href="?page=absensiinput&id_pelatihan=<?php echo $pelatihan; ?>&minggu=<?php echo $week_number; ?>">
                                        <span class="badge bg-primary p-2">
                                            <i class="fas fa-info-circle"></i> Pilih
                                        </span>
                                    </a>
                                </td>
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