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
$query = "SELECT peserta.nama, nilai.nilai
                FROM peserta
                INNER JOIN nilai ON peserta.id_peserta = nilai.id_peserta";

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
        <h1 class="mt-4">Nilai Peserta</h1>
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
                                <th>Nilai</th>
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
                                        <?php echo $row["nilai"]; ?>
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