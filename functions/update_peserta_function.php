<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_peserta = $_POST['id_peserta'];
    $id_jurusan = $_POST['id_jurusan'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telpon = $_POST['no_telpon'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $nik = $_POST['nik'];
    $kejuruan = $_POST['kejuruan'];
    $sifat = $_POST['sifat'];
    $tingkat_pelatihan = $_POST['tingkat_pelatihan'];

    $query_check_nis = "SELECT nis FROM peserta WHERE id_peserta = ?";
    $stmt_check_nis = $conn->prepare($query_check_nis);
    $stmt_check_nis->bind_param("i", $id_peserta);
    $stmt_check_nis->execute();
    $result_check_nis = $stmt_check_nis->get_result();
    $row_check_nis = $result_check_nis->fetch_assoc();
    $existing_nis = $row_check_nis['nis'];
    $existing_kejuruan = $row_check_nis['kejuruan'];
    $existing_sifat = $row_check_nis['sifat'];
    $existing_tingkat_pelatihan = $row_check_nis['tingkat_pelatihan'];

    if ($existing_nis && ($existing_kejuruan === $kejuruan && $existing_sifat === $sifat && $existing_tingkat_pelatihan === $tingkat_pelatihan)) {
        $nis = $existing_nis;
    } else {
        $query_urut = "SELECT COALESCE(MAX(CAST(SUBSTRING(nis, 1, 4) AS UNSIGNED)), 0) AS max_nis FROM peserta WHERE id_jurusan = ?";
        $stmt_urut = $conn->prepare($query_urut);
        $stmt_urut->bind_param("i", $id_jurusan);
        $stmt_urut->execute();
        $result_urut = $stmt_urut->get_result();
        $row_urut = $result_urut->fetch_assoc();
        $nomor_urut = str_pad($row_urut['max_nis'] + 1, 4, '0', STR_PAD_LEFT);

        $kode_kejuruan = "";
        switch ($kejuruan) {
            case '13':
                $kode_kejuruan = "13";
                break;
            case '04':
                $kode_kejuruan = "04";
                break;
            case '36':
                $kode_kejuruan = "36";
                break;
            case '25':
                $kode_kejuruan = "25";
                break;
            case '54':
                $kode_kejuruan = "54";
                break;
            case '16':
                $kode_kejuruan = "16";
                break;
            case '10':
                $kode_kejuruan = "10";
                break;
            case '35':
                $kode_kejuruan = "35";
                break;
            case '26':
                $kode_kejuruan = "26";
                break;
            case '50':
                $kode_kejuruan = "50";
                break;
            default:
                $kode_kejuruan = "";
                break;
        }

        $kode_tingkat_pelatihan = "";
        switch ($tingkat_pelatihan) {
            case '01':
                $kode_tingkat_pelatihan = "01";
                break;
            case '02':
                $kode_tingkat_pelatihan = "02";
                break;
            case '03':
                $kode_tingkat_pelatihan = "03";
                break;
            default:
                $kode_tingkat_pelatihan = "";
                break;
        }

        $tahun = date("Y");

        $kode_sifat = "";
        switch ($sifat) {
            case '01':
                $kode_sifat = "01";
                break;
            case '02':
                $kode_sifat = "02";
                break;
            case '03':
                $kode_sifat = "03";
                break;
            default:
                $kode_sifat = "";
                break;
        }

        if ($existing_nis) {
            $nomor_urut = substr($existing_nis, 0, 4);
        }

        $nis = $nomor_urut . "052" . $kode_tingkat_pelatihan . $kode_kejuruan . $kode_sifat . $tahun;
    }

    $query = "UPDATE peserta SET
                kejuruan = ?,
                sifat = ?,
                tingkat_pelatihan = ?,
                nama = ?,
                email = ?,
                telepon = ?,
                alamat = ?,
                jenis_kelamin = ?,
                agama = ?,
                tgl_lahir = ?,
                tempat_lahir = ?,
                nik = ?,
                nis = ?,
                id_jurusan = ?
                WHERE id_peserta = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssssssssssii', $kejuruan, $sifat, $tingkat_pelatihan, $nama, $email, $no_telpon, $alamat, $jenis_kelamin, $agama, $tgl_lahir, $tempat_lahir, $nik, $nis, $id_jurusan, $id_peserta);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Data peserta berhasil diperbarui.";
        header('Location: ../index.php');
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $stmt_urut->close();
    $stmt->close();
    $conn->close();
};
