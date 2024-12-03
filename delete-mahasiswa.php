<?php
include 'koneksi.php';

// Pastikan session sudah dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Validasi jika ada parameter id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Amankan input ID

    // Query untuk menghapus data pada tabel prodi
    $sql = "DELETE FROM mahasiswa WHERE id = $id";

    if ($conn->query($sql)) {
        // Arahkan ke halaman tampilan data prodi setelah berhasil delete
        header('Location: mahasiswa.php');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
