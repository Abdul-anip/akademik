<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'web_trpl2c';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

function cekLogin () {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}
?>
