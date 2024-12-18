<?php
require_once 'koneksi.php';

cekLogin();

if (isset($_GET['nip'])) {
    $nip = $_GET['nip'];
    $result = $conn->query("SELECT * FROM dosen WHERE nip = '$nip'");

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_dosen = $_POST['nama_dosen'];
    $prodi_id = $_POST['prodi_id'];

    // Cek apakah ada file foto yang diunggah
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto);

        // Upload foto
        if (move_uploaded_file($foto_tmp, $target_file)) {
            $foto_sql = ", foto = '$target_file'";
        } else {
            echo "Error: Gagal mengupload foto.";
            exit;
        }
    } else {
        $foto_sql = ""; // Tidak mengubah foto jika tidak ada file yang diunggah
    }

    $sql = "UPDATE dosen 
            SET nama_dosen = '$nama_dosen', prodi_id = '$prodi_id' $foto_sql
            WHERE nip = '$nip'";

    if ($conn->query($sql)) {
        header('Location: dosen.php');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

$prodiResult = $conn->query("SELECT id, nama_prodi FROM prodi");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Dosen</title>
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
            <h1 class="form-title">Edit Data Dosen</h1>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" value="<?php echo htmlspecialchars($data['nip']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                    <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="<?php echo htmlspecialchars($data['nama_dosen']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="prodi_id" class="form-label">Program Studi</label>
                    <select class="form-control" id="prodi_id" name="prodi_id" required>
                        <option value="">Pilih Program Studi</option>
                        <?php while ($prodi = $prodiResult->fetch_assoc()): ?>
                            <option value="<?php echo $prodi['id']; ?>" <?php echo ($data['prodi_id'] == $prodi['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($prodi['nama_prodi']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto (Opsional)</label>
                    <?php if (!empty($data['foto'])): ?>
                        <img src="<?php echo $data['foto']; ?>" alt="Foto Dosen" width="100" class="d-block mb-2">
                    <?php endif; ?>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
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
