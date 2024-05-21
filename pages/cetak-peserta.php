<?php
require './config/koneksi.php';
// require "W.php";
// require "R.php";
// $id_alternative = $_GET['id'];

$query = "SELECT * FROM `peserta`";
$result = $conn->query($query);
// if ($hasil) {
//     // Tampilkan data sesuai dengan id_alternative
//     while ($row = mysqli_fetch_assoc($hasil)) {
//         $nama = $row['nama'];


//     }
// }

?>

<html>

<head>
    <title>
        Nilai Guru
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <style>
        .no-border {
            border: none;
        }

        .print-button {
            display: block;
        }

        @media print {
            .print-button {
                display: none;
            }
        }

        img {
            height: 100px;
        }

        .uppercase {
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-between mt-4">
        <div></div>
        <div class="text-center">
            <p class="uppercase">
                Pemerintah kabupaten tasikmalaya
            </p>
            <h2>
                BALAI LATIHAN KERJA TASIKMALAYA
            </h2>
            <p>
                Jl. Ibrahim Adjie, Sukamajukaler, Kec. Indihiang, Kab. Tasikmalaya, Jawa Barat 46151
            </p>
        </div>
        <div>
            <img src="assets/images/logo-smpn1.jpeg" alt="">
        </div>
    </div>

    <div class="container">
        <button class="print-button border-none" onclick="window.print()">Cetak Halaman</button>
        <!-- <button class="export-button" onclick="exportToExcel()">Export to Excel</button> -->
        <div class="data-tables datatable-dark">
            <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0" data-page-length="20">

                <?php if ($result->num_rows > 0) { ?>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>NIK</th>
                            <th>Jurusan</th>
                            <th>Email</th>
                            <th>No Telpon</th>
                            <th>Alamat</th>
                            <th>Provinsi</th>
                            <th>Kab/kota</th>
                            <th>Agama</th>
                            <th>Tempat lahir</th>
                            <th>tgl lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Pendidikan</th>
                        </tr>
                    </thead>

                <?php } ?>
                <tbody>
                    <?php
                    $i = 1;
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $i++; ?>.
                                </td>
                                <td>
                                    <?php echo $row["nama"];
                                    ; ?>
                                </td>
                                <td>
                                    <?php echo $row["nis"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["nik"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["id_jurusan"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["email"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["telepon"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["alamat"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["provinsi"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["kab/kota"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["agama"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["tempat_lahir"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["tgl_lahir"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["jenis_kelamin"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["pendidikan"]; ?>
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
        <div class="container d-flex justify-content-between">
            <div></div>
            <div>
                Tasikmalaya, <span id="tanggalwaktu"></span>
                <br>
                <br>
                <br>
                <br>

                ___________________________________
                <br>
                (Kepala)
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#mauexport').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        footer: true
                    },
                    // {
                    //     extend: 'pdf',
                    //     footer: true
                    // },
                    // {
                    //     extend: 'print',
                    //     footer: true
                    // }
                ]
            });
        });
    </script>
    <script>
        var dt = new Date();
        var bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        var namaBulan = bulan[dt.getMonth()];

        document.getElementById("tanggalwaktu").innerHTML = ("0" + dt.getDate()).slice(-2) + " " + namaBulan + " " + dt.getFullYear();
    </script>

</body>

</html>