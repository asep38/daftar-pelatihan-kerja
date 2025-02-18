<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}

$idPelatihan = isset($_GET['id_pelatihan']) ? intval($_GET['id_pelatihan']) : 0;

require_once('./config/koneksi.php');

$query = "SELECT peserta.id_peserta, peserta.nama, COALESCE(nilai.nilai, 'Belum dinilai') AS nilai
          FROM peserta
          LEFT JOIN nilai ON peserta.id_peserta = nilai.id_peserta AND nilai.id_pelatihan = $idPelatihan
          WHERE peserta.id_jurusan IN (SELECT id_jurusan FROM pelatihan WHERE id_pelatihan = $idPelatihan)";

$result = $conn->query($query);

if (!$result) {
    die("Query Error: " . $conn->error);
}
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
    <div class="modal modal-backdrop fade" id="editNilaiModal" tabindex="-1" aria-labelledby="editNilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNilaiModalLabel">Edit Nilai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('editNilaiModal')"></button>
                </div>
                <div class="modal-body">
                    <form id="editNilaiForm" onsubmit="simpanEditNilai(); return false;">
                        <input type="hidden" id="id_peserta" name="id_peserta">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="nama_peserta" name="nama_peserta" type="text" placeholder="Nama" disabled required />
                                    <label for="nama-peserta">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="nilai_peserta" name="nilai_peserta" type="number" placeholder="Nilai" required />
                                    <label for="nilai-peserta">Nilai</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-0">
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary" onclick="closeModal('editNilaiModal')">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal modal-backdrop fade" id="nilaiModal" tabindex="-1" aria-labelledby="nilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nilaiModalLabel">Tambah Nilai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('nilaiModal')"></button>
                </div>
                <div class="modal-body">
                    <form id="tambahForm" onsubmit="simpanNilai(); return false;">
                        <input type="hidden" id="id-peserta" name="id-peserta">
                        <input type="hidden" id="id-pelatihan" name="id-pelatihan" value="<?php echo $idPelatihan; ?>">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="nama-peserta" name="nama-peserta" type="text" placeholder="Nama" disabled required />
                                    <label for="nama-peserta">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="nilai-peserta" name="nilai-peserta" type="number" placeholder="Nilai" required />
                                    <label for="nilai-peserta">Nilai</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-0">
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary" onclick="closeModal('nilaiModal')">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Peserta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb=4">
            <div class="card-header">
                <a href="?page=rekapnilai" class="btn btn-primary">Rekap Nilai</a>
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
                                <th>Nilai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5">No Data Found</td>
                        </tr>
                    <?php } ?>
                    <tbody>
                        <?php
                        $i = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?>.</td>
                                    <td><?php echo htmlspecialchars($row["nama"]); ?></td>
                                    <td><?php echo isset($row["nilai"]) ? htmlspecialchars($row["nilai"]) : 'Belum ada nilai'; ?></td>
                                    <td>
                                        <a class="pointer me-2" onclick="showNilaiModal(<?php echo $row['id_peserta']; ?>)">
                                            <span class="badge bg-primary p-2">
                                                <i class="fas fa-plus-circle"></i> Nilai
                                            </span>
                                        </a>
                                        <a class="pointer text-primary" onclick="showEditNilaiModal(<?php echo $row['id_peserta']; ?>)">
                                            <span class="badge bg-warning p-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No Data Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    function showNilaiModal(idPeserta) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/detail_peserta_function.php?id=' + idPeserta, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById('id-peserta').value = data.id_peserta;
                document.getElementById('nama-peserta').value = data.nama;
                showModal('nilaiModal');
            }
        };
        xhr.send();
    }

    function simpanNilai() {
        const formData = new FormData(document.getElementById('tambahForm'));
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './functions/nilai_function.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                closeModal('nilaiModal');
                window.location.reload();
            }
        };
        xhr.send(formData);
    }

    function showEditNilaiModal(idPeserta) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/get_nilai_function.php?id=' + idPeserta, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.response === "Data nilai tidak ditemukan") {
                    alert("Tambahkan nilai terlebih dahulu kepada peserta sebelum melakukan edit");
                } else {
                    const data = JSON.parse(xhr.responseText);
                    document.getElementById('id_peserta').value = data.id_peserta;
                    document.getElementById('nama_peserta').value = data.nama;
                    document.getElementById('nilai_peserta').value = data.nilai;
                    showModal('editNilaiModal');
                }
            }
        };
        xhr.send();
    }

    function simpanEditNilai() {
        const formData = new FormData(document.getElementById('editNilaiForm'));
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './functions/update_nilai_function.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                closeModal('editNilaiModal');
                window.location.reload();
            }
        };
        xhr.send(formData);
    }

    function showModal(idModal) {
        document.getElementById(idModal).classList.add("fade");
        document.getElementById(idModal).style.display = "block";
        setTimeout(function() {
            document.getElementById(idModal).classList.add("show");
            document.body.classList.add("modal-open");
        }, 100);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modalBackdrops = document.querySelectorAll('.modal-backdrop');

        modalBackdrops.forEach(function(modalBackdrop) {
            modalBackdrop.addEventListener('click', function(event) {
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