<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page</title>
    <style>
        /* Style untuk halaman cetak */
        @media print {

            /* Sembunyikan tombol cetak saat dicetak */
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="content">
        <!-- Konten halaman yang ingin dicetak -->
        <h1>Halaman Cetak</h1>
        <p>Ini adalah konten halaman yang ingin dicetak.</p>
    </div>

    <!-- Tombol untuk mencetak halaman -->
    <button class="no-print" onclick="window.print()">Cetak Halaman</button>

</body>

</html>