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
$query = "SELECT * FROM peserta";

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
                    <h5 class="modal-title" id="editModalLabel">Edit Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="closeModal('editModal')"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="id_peserta" name="id_peserta" value="<?php echo $idPeserta; ?>">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="nama" name="nama" type="text" placeholder="Nama"
                                        required />
                                    <label for="nama">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="email" name="email" type="email"
                                        placeholder="name@example.com" required />
                                    <label for="email">Email address</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="no_telpon" name="no_telpon" type="tel"
                                        placeholder="Nomor Telepon" required />
                                    <label for="no_telpon">Nomor Telepon</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="alamat" name="alamat" type="text"
                                        placeholder="Alamat" required />
                                    <label for="alamat">Alamat</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="agama" name="agama" type="text" placeholder="Agama"
                                        required />
                                    <label for="agama">Agama</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="tgl_lahir" name="tgl_lahir" type="date"
                                        placeholder="Tanggal Lahir" required />
                                    <label for="tgl_lahir">Tanggal Lahir (mm/dd/yyyy)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="tempat_lahir" name="tempat_lahir" type="text"
                                        placeholder="Tempat Lahir" required />
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="nik" name="nik" type="text" placeholder="NIK"
                                        required />
                                    <label for="nik">NIK</label>
                                </div>
                            </div>
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
                    <h5 class="modal-title" id="detailModalLabel">Detail Peserta</h5>
                    <button type="button" class="btn-close" aria-label="Close"
                        onclick="closeModal('detailModal')"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama : </strong><br><span id="modal-nama"></span></p>
                    <p><strong>Email : </strong><br><span id="modal-email"></span></p>
                    <p><strong>No Telpon : </strong><br><span id="modal-no-telpon"></span></p>
                    <p><strong>Tempat Lahir : </strong><br><span id="modal-tempat-lahir"></span></p>
                    <p><strong>Tgl Lahir : </strong><br><span id="modal-tgl-lahir"></span></p>
                    <p><strong>Jenis Kelamin : </strong><br><span id="modal-jenis-kelamin"></span></p>
                    <p><strong>Agama : </strong><br><span id="modal-agama"></span></p>
                    <p><strong>NIK : </strong><br><span id="modal-nik"></span></p>
                    <p><strong>Alamat : </strong><br><span id="modal-alamat"></span></p>
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

        <div class="card mb-4">
            <div class="card-body">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic facere assumenda in corrupti repudiandae
                delectus magnam soluta natus veniam aliquam id sequi modi aspernatur libero officiis illo eveniet,
                quidem a.
            </div>
        </div>
        <a class="btn btn-success mb-4" href="?page=cetakpeserta">
            Cetak Peserta
        </a>
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
                                <th>NIS</th>
                                <th>Email</th>
                                <th>No Telpon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIS</th>
                                <th>Email</th>
                                <th>No Telpon</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
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
                                        <?php echo $row["nis"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["email"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["telepon"]; ?>
                                    </td>
                                    <td>
                                        <a class="pointer me-2" onclick="showDetail(<?php echo $row['id_peserta']; ?>)">
                                            <span class="badge bg-primary p-2">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </span>
                                        </a>
                                        <a class="pointer me-2" onclick="showEditModal(<?php echo $row['id_peserta']; ?>)">
                                            <span class="badge bg-warning p-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </span>
                                        </a>
                                        <a class="pointer me-2"
                                            onclick="showModalDelete(<?php echo $row['id_peserta']; ?>, '<?php echo $row['nama']; ?>')">
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
    function showDetail(idPeserta) {
        const modalNama = document.getElementById('modal-nama');
        const modalEmail = document.getElementById('modal-email');
        const modalNoTelpon = document.getElementById('modal-no-telpon');
        const modalTempatLahir = document.getElementById('modal-tempat-lahir');
        const modalTglLahir = document.getElementById('modal-tgl-lahir');
        const modalEnisKelamin = document.getElementById('modal-jenis-kelamin');
        const modalAgama = document.getElementById('modal-agama');
        const modalNik = document.getElementById('modal-nik');
        const modalAlamat = document.getElementById('modal-alamat');

        const xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/detail_peserta_function.php?id=' + idPeserta, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const data = JSON.parse(xhr.responseText);
                modalNama.textContent = data.nama;
                modalEmail.textContent = data.email;
                modalNoTelpon.textContent = data.no_telpon;
                modalTempatLahir.textContent = data.tempat_lahir;
                modalTglLahir.textContent = data.tgl_lahir;
                modalEnisKelamin.textContent = data.jenis_kelamin;
                modalAgama.textContent = data.agama;
                modalNik.textContent = data.nik;
                modalAlamat.textContent = data.alamat;

                showModal('detailModal')
            }
        };
        xhr.send();
    }

    let deleteId;

    function showModalDelete(idPeserta, nama) {
        const modalBody = document.querySelector('#confirmDeleteModal .modal-body');
        modalBody.innerHTML = `Apakah Anda yakin ingin menghapus peserta dengan nama ${nama}?`;
        deleteId = idPeserta;
        showModal('confirmDeleteModal')
    }

    function confirmDelete() {
        window.location.href = "./functions/delete_peserta_function.php?id=" + deleteId;
    }

    function showEditModal(idPeserta) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', './functions/detail_peserta_function.php?id=' + idPeserta, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const data = JSON.parse(xhr.responseText);
                document.getElementById('id_peserta').value = data.id_peserta;
                document.getElementById('nama').value = data.nama;
                document.getElementById('email').value = data.email;
                document.getElementById('alamat').value = data.alamat;
                document.getElementById('no_telpon').value = data.no_telpon;
                document.getElementById('tempat_lahir').value = data.tempat_lahir;
                document.getElementById('tgl_lahir').value = data.tgl_lahir;
                document.getElementById('jenis_kelamin').value = data.jenis_kelamin;
                document.getElementById('agama').value = data.agama;
                document.getElementById('nik').value = data.nik;

                showModal('editModal');
            }
        };
        xhr.send();
    }

    document.getElementById('editForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        console.log(formData)
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './functions/update_peserta_function.php', true);
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