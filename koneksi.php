<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'web_trpl2c';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

// Fungsi untuk memastikan pengguna sudah login
if (!function_exists('cekLogin')) {
    function cekLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }
    }
}

// Fungsi untuk memeriksa hak akses pengguna
function cekRole($allowed_roles) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['level'])) {
        header('Location: login.php');
        exit;
    }
    if (!in_array($_SESSION['level'], $allowed_roles)) {
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini.'); window.history.back();</script>";
        exit;
    }
}
?>
