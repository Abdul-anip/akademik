<?php
include 'koneksi.php';

cekLogin();

$table = 'prodi'; 
$id = intval($_GET['id']);

$result = $conn->query("SELECT * FROM $table WHERE id = $id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses edit data
    $nama_prodi = $_POST['nama_prodi'];
    $jenjang = $_POST['jenjang'];
    $keterangan = $_POST['keterangan'];

    $sql = "UPDATE prodi SET nama_prodi = '$nama_prodi', jenjang = '$jenjang', keterangan = '$keterangan' WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: prodi.php"); //  kembali ke halaman data prodi
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
  <head>
    <script src="assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Edit Data Prodi</title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #384B70;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
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
    <!-- Begin page content -->
    
      <div class="container">
        <div class="form-container">
        <h1 class="form-title">Edit Data Prodi</h1>
                <form method="POST">
                <div class="mb-3">
                    <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                    <input type="text" class="form-control" id="nama_prodi" name="nama_prodi" value="<?php echo htmlspecialchars($data['nama_prodi']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="jenjang" class="form-label">Jenjang</label>
                    <input type="text" class="form-control" id="jenjang" name="jenjang" value="<?php echo htmlspecialchars($data['jenjang']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4" required><?php echo htmlspecialchars($data['keterangan']); ?></textarea>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="prodi.php" class="btn btn-secondary">Kembali</a>
                </div>
                </form>
            </div>
      </div>

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
