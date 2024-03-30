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
$query = "SELECT p.id_pelatihan, p.deskripsi, p.tanggal_mulai, p.tanggal_selesai, p.tempat, j.nama_jurusan 
          FROM pelatihan p 
          INNER JOIN jurusan j ON p.id_jurusan = j.id_jurusan";

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
    <div class="modal modal-backdrop fade" id="confirmDeleteModal" tabindex="-1"
        aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="closeModal('confirmDeleteModal')"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus peserta ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="closeModal('confirmDeleteModal')">Tidak</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-backdrop fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pelatihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="closeModal('editModal')"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="id_pelatihan" name="id_pelatihan" value="<?php echo $idPelatihan; ?>">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pelatihan</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="tempat" class="form-label">Tempat</label>
                            <input type="text" class="form-control" id="tempat" name="tempat" required>
                        </div>
                        <div class="mt-4 mb-0">
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary"
                                    onclick="closeModal('editModal')">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal modal-backdrop fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pelatihan</h5>
                    <button type="button" class="btn-close" aria-label="Close"
                        onclick="closeModal('detailModal')"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Pelatihan : </strong><br><span id="detail_nama"></span></p>
                    <p><strong>Deskripsi : </strong><br><span id="detail_deskripsi"></span></p>
                    <p><strong>Tanggal Mulai : </strong><br><span id="detail_tanggal_mulai"></span></p>
                    <p><strong>Tanggal Selesai : </strong><br><span id="detail_tanggal_selesai"></span></p>
                    <p><strong>Tempat : </strong><br><span id="detail_tempat"></span></p>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal modal-backdrop fade" id="pelatihanModal" tabindex="-1" aria-labelledby="pelatihanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pelatihanModalLabel">Detail Peserta</h5>
                    <button type="button" class="btn-close" aria-label="Close"
                        onclick="closeModal('pelatihanModal')"></button>
                </div>
                <div class="modal-body">
                    <form action="./functions/create_pelatihan_function.php" method="POST">
                        <div class="mb-3">
                            <label for="idjurusan" class="form-label">Nama Pelatihan</label>
                            <select class="form-select" id="idjurusan" name="idjurusan">
                                <?php
                                require_once ('./config/koneksi.php');
                                $i = 1;
                                $ambilsemuadata = mysqli_query($conn, "SELECT * FROM jurusan");
                                while ($fetcharray = mysqli_fetch_array($ambilsemuadata)) {
                                    $namajurusan = $fetcharray['nama_jurusan'];
                                    $idjurusan = $fetcharray['id_jurusan'];

                                    ?>

                                    <option value="<?= $idjurusan; ?>">
                                        <?= $i++; ?>
                                        <?= $namajurusan; ?>
                                    </option>

                                    <?php
                                }
                                ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="tempat" class="form-label">Tempat</label>
                            <input type="text" class="form-control" id="tempat" name="tempat" required>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                onclick="closeModal('pelatihanModal')">Close</button>
                            <button type="submit" class="btn btn-success">Tambah Data</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Pelatihan Kerja</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat et laudantium explicabo corporis
                deserunt possimus vel minima molestiae porro nihil, officia ut numquam, vitae tenetur error facilis
                doloribus.
            </div>
        </div>
        <div class="mb-4">
            <button type="button" class="btn btn-success" onclick="showModal('pelatihanModal')">
                Tambah Pelatihan Kerja
            </button>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Pelatihan Kerja
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <?php if ($result->num_rows > 0) { ?>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelatihan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelatihan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    <?php } ?>
                    <tbody>
                        <?php
                        $i = 1;
                        if ($result->num_rows > 0) {
                            while (
                                $row =
                                $result->fetch_assoc()
                            ) {

                                ?>
                                <tr>
                                    <td>
                                        <?php echo $i++; ?>.
                                    </td>
                                    <td>
                                        <?php echo $row["nama_jurusan"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["tanggal_mulai"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["tanggal_selesai"]; ?>
                                    </td>
                                    <td>
                                        <a class="pointer me-2" onclick="showDetail(<?php echo $row['id_pelatihan']; ?>)">
                                            <span class="badge bg-primary p-2">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </span>
                                        </a>
                                        <a class="pointer me-2" onclick="showEditModal(<?php echo $row['id_pelatihan']; ?>)">
                                            <span class="badge bg-warning p-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </span>
                                        </a>
                                        <a class="pointer me-2"
                                            onclick="showModalDelete(<?php echo $row['id_pelatihan']; ?>, '<?php echo $row['nama_jurusan']; ?>')">
                                            <span class="badge bg-danger p-2">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </span>
                                        </a>
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
    function showEditModal(idPelatihan) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/detail_pelatihan_function.php?id=' + idPelatihan, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById('id_pelatihan').value = data.id_pelatihan;
                document.getElementById('nama').value = data.nama;
                document.getElementById('deskripsi').value = data.deskripsi;
                document.getElementById('tanggal_mulai').value = data.tanggal_mulai;
                document.getElementById('tanggal_selesai').value = data.tanggal_selesai;
                document.getElementById('tempat').value = data.tempat;

                showModal('editModal');
            }
        };
        xhr.send();
    }

    document.getElementById('editForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './functions/update_pelatihan_function.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                const modal = document.getElementById('editModal');
                modal.classList.remove('show');
                document.body.classList.remove('modal-open');
                window.location.reload();
            }
        };
        xhr.send(formData);
    });

    function showDetail(idPelatihan) {
        const nama = document.getElementById('detail_nama');
        const deskripsi = document.getElementById('detail_deskripsi');
        const tanggal_mulai = document.getElementById('detail_tanggal_mulai');
        const tanggal_selesai = document.getElementById('detail_tanggal_selesai');
        const tempat = document.getElementById('detail_tempat');

        const xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/detail_pelatihan_function.php?id=' + idPelatihan, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const data = JSON.parse(xhr.responseText);
                nama.textContent = data.nama;
                deskripsi.textContent = data.deskripsi;
                tanggal_mulai.textContent = data.tanggal_mulai;
                tanggal_selesai.textContent = data.tanggal_selesai;
                tempat.textContent = data.tempat;

                showModal('detailModal')
            }
        };
        xhr.send();
    }

    function showModalDelete(idPeserta, nama) {
        const modalBody = document.querySelector('#confirmDeleteModal .modal-body');
        modalBody.innerHTML = `Apakah Anda yakin ingin menghapus pelatihan dengan nama pelatihan ${nama}?`;
        deleteId = idPeserta;
        showModal('confirmDeleteModal')
    }

    function confirmDelete() {
        window.location.href = "./functions/delete_pelatihan_function.php?id=" + deleteId;
    }

    function showModal(idModal) {
        document.getElementById(idModal).classList.add("fade");
        document.getElementById(idModal).style.display = "block";
        setTimeout(function () {
            document.getElementById(idModal).classList.add("show");
            document.body.classList.add("modal-open");
        }, 100);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modalBackdrops = document.querySelectorAll('.modal-backdrop');

        modalBackdrops.forEach(function (modalBackdrop) {
            modalBackdrop.addEventListener('click', function (event) {
                if (event.target === modalBackdrop) {
                    const modal = modalBackdrop.closest('.modal')
                    const modalId = modal.getAttribute('id');
                    closeModal(modalId);
                }
            });
        });
    });

    function closeModal(idModal) {
        const modal = document.getElementById(idModal);
        if (!modal) return;

        modal.classList.remove("show");
        document.body.classList.remove("modal-open");
        setTimeout(() => {
            modal.style.display = "none";
            modal.classList.remove("fade");
        }, 500);
    }
</script>