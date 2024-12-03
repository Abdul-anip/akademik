<?php
include 'koneksi.php';

cekLogin();

session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit;
?>
