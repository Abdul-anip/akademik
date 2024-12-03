<?php
include 'koneksi.php';

cekLogin();

// Validasi jika ada parameter id dan table
if (isset($_GET['id']) && isset($_GET['table'])) {
    $id = intval($_GET['id']); 
    $table = $_GET['table'];

    $nama_tables = ['prodi', 'mahasiswa']; 
    if (in_array($table, $nama_tables)) {
        if ($table === 'prodi'){
            $cek = $conn->query("select count(*) AS count from mahasiswa where prodi_id = $id");
            $data = $cek->fetch_assoc();

            if ($data['count'] > 0) {
                echo "Data tidak boleh dihapus karena ada mahasiswa yang terdaftar di program studi ini.";
                exit;
        }
    }
       
        $sql = "DELETE FROM $table WHERE id = $id";

        if ($conn->query($sql)) {
            if ($table === 'prodi') {
                header('Location: prodi.php');
            } elseif ($table === 'mahasiswa') {
                header('Location: mahasiswa.php');
            }
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Tabel tidak valid.";
    }
} else {
    echo "ID atau tabel tidak ditemukan.";
}
?>
