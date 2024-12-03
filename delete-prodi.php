<?php
include 'koneksi.php';

cekLogin();

// Validasi jika ada parameter id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Amankan input ID

    // Query untuk menghapus data pada tabel prodi
    $sql = "DELETE FROM prodi WHERE id = $id";

    if ($conn->query($sql)) {
        // Arahkan ke halaman tampilan data prodi setelah berhasil delete
        header('Location: prodi.php');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
