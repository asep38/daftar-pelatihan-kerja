<?php
require './config/koneksi.php';
// require "W.php";
// require "R.php";
// $id_alternative = $_GET['id'];
$id_peserta = $_GET['id_peserta'];

$query = "SELECT nama FROM peserta WHERE id_peserta = $id_peserta";
$result = $conn->query($query);
if ($result) {
    // Tampilkan data sesuai dengan id_alternative
    while ($row = mysqli_fetch_assoc($result)) {
        $nama = $row['nama'];


    }
}

?>

<html>

<head>

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
        <div>
            <img src="assets/img/Logo_Kementerian_Ketenagakerjaan_(2016).png" alt="">
        </div>
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
            <img src="assets/img/Seal_of_Tasikmalaya_Regency.svg.png" alt="">
        </div>
    </div>

    <div class="container">
        <button class="print-button border-none" onclick="window.print()">Cetak Halaman</button>
        <!-- <button class="export-button" onclick="exportToExcel()">Export to Excel</button> -->
        <br>
        <br>
        <br>
        <h1 class="text-center">SERTIFIKAT</h1>
        <div class="text-center">Kepala UPTD Latihan Kerja Kabupaten Tasikmalaya, berdasarkan Surat Keputusan
            Penyelenggaraan Pelatihan
            No.2.5/739/kp.11.00/III/2022, Menyatakan bahwa:
        </div>
        <br>
        <br>
        <br>
        <h2 class="text-center"><?php echo $nama; ?></h2>
        <br>
        <br>
        <br>
        <h3 class="text-center">TELAH MENGIKUTI</h3>
        <br>
        <div class="text-center">Pelatihan berbasis kompetensi (PBK) dan dinyatakan <strong>Lulus.</strong></div>
        <br>
        <br>
        <br>

        <div class="container d-flex justify-content-between">
            <div></div>
            <br>
            <br>
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