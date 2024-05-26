<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pendaftaran - Pelatihan Kerja</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Daftar Pelatihan</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="./functions/register_function.php">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="nama" name="nama" type="text" placeholder="Nama" autofocus required />
                                                    <label for="nama">Nama</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com" required />
                                                    <label for="email">Email address</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="no_telpon" name="no_telpon" type="tel" placeholder="Nomor Telepon" required />
                                                    <label for="no_telpon">Nomor Telepon</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="alamat" name="alamat" type="text" placeholder="Alamat" required />
                                                    <label for="alamat">Alamat</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                                        <option value="Laki-Laki">Laki-laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>
                                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="agama" name="agama" type="text" placeholder="Agama" required />
                                                    <label for="agama">Agama</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="tgl_lahir" name="tgl_lahir" type="date" placeholder="Tanggal Lahir" required />
                                                    <label for="tgl_lahir">Tanggal Lahir (mm/dd/yyyy)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="tempat_lahir" name="tempat_lahir" type="text" placeholder="Tempat Lahir" required />
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="nik" name="nik" type="text" maxlength="16" placeholder="NIK" oninput="if(this.value.length > 16) this.value = this.value.slice(0, 16);" required />
                                                    <label for="nik">NIK</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-select" id="idjurusan" name="idjurusan">
                                                        <?php
                                                        require_once('./config/koneksi.php');
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
                                                    <label for="idjurusan">Jurusan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-select" id="provinsi" name="provinsi" required>
                                                        <option value="" disabled selected>Provinsi</option>
                                                        <option value="Jawa Barat">Jawa Barat</option>
                                                    </select>
                                                    <label for="provinsi">Provinsi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-select" id="kab_kota" name="kab_kota" required>
                                                        <option value="" disabled selected>Kab/Kota</option>
                                                        <option value="Tasikmalaya">Tasikmalaya</option>
                                                    </select>
                                                    <label for="kab_kota">Kab/Kota</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-select" id="pendidikan" name="pendidikan" required>
                                                        <option value="" disabled selected>Pendidikan</option>
                                                        <option value="SMP">SMP</option>
                                                        <option value="SMA">SMA</option>
                                                        <option value="D3">D3</option>
                                                        <option value="S1">S1</option>
                                                    </select>
                                                    <label for="pendidikan">Pendidikan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-select" id="tingkat_pelatihan" name="tingkat_pelatihan" required>
                                                        <option value="" disabled selected>Tingkat Pelatihan</option>
                                                        <option value="01">Tingkat Latihan Dasar</option>
                                                        <option value="02">Tingkat Latihan Menengah</option>
                                                        <option value="03">Tingkat Latihan Mahir</option>
                                                    </select>
                                                    <label for="tingkat_pelatihan">Tingkat Pelatihan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-select" id="kejuruan" name="kejuruan" required>
                                                        <option value="" disabled selected>Kejuruan</option>
                                                        <option value="13">Mobil Bensin</option>
                                                        <option value="04">Mekanik Logam/Las Listrik/Karbit</option>
                                                        <option value="36">Bordir/Menjahit/Anyaman</option>
                                                        <option value="25">Processing</option>
                                                        <option value="54">Perikanan</option>
                                                        <option value="16">Sepeda Motor</option>
                                                        <option value="10">Electro/Listrik</option>
                                                        <option value="35">Tata Niaga/Komputer/TU</option>
                                                        <option value="26">Bangunan</option>
                                                        <option value="50">Holtikultura</option>
                                                    </select>
                                                    <label for="kejuruan">Kejuruan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <select class="form-select" id="sifat" name="sifat" required>
                                                        <option value="" disabled selected>Sifat</option>
                                                        <option value="01">Institusional</option>
                                                        <option value="02">Non Institusional</option>
                                                        <option value="03">Pihak Ketiga (Privat, PSG, DD)</option>
                                                    </select>
                                                    <label for="sifat">Sifat</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="nis" name="nis" type="hidden" placeholder="NIS" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button class="btn btn-primary" type="submit">Daftar</button></div>
                                        </div>
                                    </form>
                                </div>
                                <!-- <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer" class="mt-5">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>