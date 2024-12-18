<?php
include 'koneksi.php';

cekLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip = $_POST['nip'];
    $nama_dosen = $_POST['nama_dosen'];
    $prodi_id = $_POST['prodi_id'];
    $foto = $_FILES['foto']['name'];
    $foto_tempat = $_FILES['foto']['tmp_name'];

    $cek_nip = $conn->query("select * from dosen where nip = '$nip'");

    if($cek_nip->num_rows > 0){
        echo "<script>alert('NIP sudah digunakan! Silakan masukkan NIP yang berbeda.');</script>";
    }else{
        $target_direktori = "uploads/";
        if (!is_dir($target_direktori)) {
            mkdir($target_direktori, 0755, true);
        }
        $target_file = $target_direktori . basename($foto);

        // Upload file foto
        if (move_uploaded_file($foto_tempat, $target_file)) {
            $sql = "INSERT INTO dosen (nip, nama_dosen, prodi_id, foto) 
                    VALUES ('$nip', '$nama_dosen', '$prodi_id', '$target_file')";

            if ($conn->query($sql)) {
                header('Location: dosen.php');
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            die("Error: Gagal mengupload foto. Periksa izin folder.");
        }
        
    }

}

// ambil duta dari tabel prodi dropdown
$prodiResult = $conn->query("SELECT id, nama_prodi FROM prodi");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #384B70;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .form-footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="form-title">Tambah Data Dosen</h1>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" maxlength="18" required>
                </div>
                <div class="mb-3">
                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                    <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" required>
                </div>
                <div class="mb-3">
                    <label for="prodi_id" class="form-label">Program Studi</label>
                    <select class="form-control" id="prodi_id" name="prodi_id" required>
                        <option value="">Pilih Program Studi</option>
                        <?php while ($prodi = $prodiResult->fetch_assoc()): ?>
                            <option value="<?php echo $prodi['id']; ?>">
                                <?php echo htmlspecialchars($prodi['nama_prodi']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="dosen.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
