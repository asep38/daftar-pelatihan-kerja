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

require_once ('./config/koneksi.php');
$query = "SELECT * FROM jurusan";

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
                    Apakah Anda yakin ingin menghapus jurusan ini?
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
                    <h5 class="modal-title" id="editModalLabel">Edit Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="closeModal('editModal')"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="id_jurusan" name="id_jurusan" value="<?= $idJurusan; ?>">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="jurusan" name="jurusan" type="text"
                                        placeholder="jurusan" required />
                                    <label for="jurusan">Nama jurusan</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-3">
                            <div class="col-md-12">
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

    <div class="modal modal-backdrop fade" id="jurusanModal" tabindex="-1" aria-labelledby="jurusanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jurusanModalLabel">Detail Peserta</h5>
                    <button type="button" class="btn-close" aria-label="Close"
                        onclick="closeModal('jurusanModal')"></button>
                </div>
                <div class="modal-body">
                    <form action="./functions/create_jurusan_function.php" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="jurusan" name="jurusan" type="text"
                                        placeholder="jurusan" required />
                                    <label for="jurusan">Nama jurusan</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-3">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary"
                                    onclick="closeModal('jurusanModal')">Batal</button>
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
        <h1 class="mt-4">Daftar Jurusan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Tables</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic facere assumenda in corrupti repudiandae
                delectus magnam soluta natus veniam aliquam id sequi modi aspernatur libero officiis illo eveniet,
                quidem a.
            </div>
        </div>
        <div class="mb-4">
            <button type="button" class="btn btn-success" onclick="showModal('jurusanModal')">
                Tambah Jurusan
            </button>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Data Table Jurusan
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <?php if ($result->num_rows > 0) { ?>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
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
                                        <?php echo $row["nama_jurusan"]; ?>
                                    </td>

                                    <td>

                                        <a class="pointer me-2" onclick="showEditModal(<?php echo $row['id_jurusan']; ?>)">
                                            <span class="badge bg-warning p-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </span>
                                        </a>
                                        <a class="pointer me-2"
                                            onclick="showModalDelete(<?php echo $row['id_jurusan']; ?>, '<?php echo $row['nama_jurusan']; ?>')">
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


    let deleteId;

    function showModalDelete(idJurusan, nama_jurusan) {
        const modalBody = document.querySelector('#confirmDeleteModal .modal-body');
        modalBody.innerHTML = `Apakah Anda yakin ingin menghapus Jurusan ${nama_jurusan}?`;
        deleteId = idJurusan;
        showModal('confirmDeleteModal')
    }

    function confirmDelete() {
        window.location.href = "./functions/delete_jurusan_function.php?id=" + deleteId;
    }

    function showEditModal(idJurusan) {
        console.log("showEditModal called with idJurusan:", idJurusan); // Log ID yang diterima
        const xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/update_jurusan_function.php?id=' + idJurusan, true);
        xhr.onreadystatechange = function () {
            console.log("readyState:", xhr.readyState, "status:", xhr.status); // Log status dari XHR
            if (xhr.readyState == 4 && xhr.status == 200) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    console.log("data:", data); // Log data yang diterima dari server
                    document.getElementById('id_jurusan').value = data.id_jurusan;
                    document.getElementById('jurusan').value = data.nama_jurusan;
                    showModal('editModal');
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.error('Response:', xhr.responseText); // Log respons jika ada kesalahan
                }
            } else if (xhr.readyState == 4) {
                console.error('Error with request:', xhr.status, xhr.statusText); // Log error jika status bukan 200
            }
        };
        xhr.send();
    }

    document.getElementById('editForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './functions/update_jurusan_function.php', true);
        xhr.onreadystatechange = function () {
            console.log("readyState:", xhr.readyState, "status:", xhr.status); // Log status dari XHR
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                closeModal('editModal');
                window.location.reload();
            }
        };
        xhr.send(formData);
    });

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