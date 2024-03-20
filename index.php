<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Home - Pelatihan Kerja</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <h1>Selamat Datang : <?php echo isset($_SESSION['logged_in']) ? $_SESSION['nama'] : ''; ?></h1>
                            <a class="btn btn-<?php echo isset($_SESSION['logged_in']) ? 'warning' : 'secondary'; ?>" href="<?php echo isset($_SESSION['logged_in']) ? './functions/logout_function.php' : './login.php'; ?>">
                                <?php echo isset($_SESSION['logged_in']) ? 'LogOut' : 'Login'; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
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
    <script>
        const loginsuccess = document.cookie.split(';').some((item) => item.trim().startsWith('login_success='));
        if (loginsuccess) {
            alert('Login Success, Selamat datang');
        }
        document.cookie = 'login_success=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    </script>
</body>

</html>