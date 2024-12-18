<?php
include 'koneksi.php';

cekLogin();

if ((isset($_GET['id']) || isset($_GET['nip'])) && isset($_GET['table'])) {
    $table = $_GET['table'];

    
    $nama_tables = ['prodi', 'mahasiswa', 'dosen']; 
    if (in_array($table, $nama_tables)) {
        
        if ($table === 'prodi') {
            $id = intval($_GET['id']); // Gunakan `id` untuk prodi
            $cekMahasiswa = $conn->query("SELECT COUNT(*) AS count FROM mahasiswa WHERE prodi_id = $id");
            $cekDosen = $conn->query("SELECT COUNT(*) AS count FROM dosen WHERE prodi_id = $id");
            $dataMahasiswa = $cekMahasiswa->fetch_assoc();
            $dataDosen = $cekDosen->fetch_assoc();

            if ($dataMahasiswa['count'] > 0 || $dataDosen['count'] > 0) {
                echo "Data tidak boleh dihapus karena ada mahasiswa atau dosen yang terdaftar di program studi ini.";
                exit;
            }
            $sql = "DELETE FROM $table WHERE id = $id";
        } elseif ($table === 'mahasiswa') {
            $id = intval($_GET['id']); // Gunakan `id` untuk mahasiswa
            $sql = "DELETE FROM $table WHERE id = $id";
        } elseif ($table === 'dosen') {
            $nip = $_GET['nip']; // Gunakan `nip` untuk dosen
            $sql = "DELETE FROM $table WHERE nip = '$nip'";
        }

        // Eksekusi
        if ($conn->query($sql)) {
            if ($table === 'prodi') {
                header('Location: prodi.php');
            } elseif ($table === 'mahasiswa') {
                header('Location: mahasiswa.php');
            } elseif ($table === 'dosen') {
                header('Location: dosen.php');
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
