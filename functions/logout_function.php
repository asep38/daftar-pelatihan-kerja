<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();

header("Location: /daftar-pelatihan-kerja/");
exit();
