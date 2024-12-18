<?php
require_once 'koneksi.php';


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mengamankan input ID
    $result = $conn->query("SELECT * FROM mahasiswa WHERE id = $id");

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nim = $_POST['nim'];
    $gender = $_POST['gender'];
    $hobi = implode(", ", $_POST['hobi']);
    $alamat = $_POST['alamat'];
    $prodi_id = $_POST['prodi_id'];

    $sql = "UPDATE mahasiswa 
            SET nama = '$nama', email = '$email', nim = '$nim', gender = '$gender', hobi = '$hobi', alamat = '$alamat', prodi_id = '$prodi_id'
            WHERE id = $id";

    if ($conn->query($sql)) {
        header('Location: mahasiswa.php');
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
    <title>Tambah Mahasiswa</title>
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
            <h1 class="form-title">Tambah Data Mahasiswa</h1>
            <form method="post">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="<?php echo htmlspecialchars($data['nim']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Laki-laki" <?php if ($data['gender'] == 'Laki-laki') echo 'checked'; ?> required>
                            <label class="form-check-label" for="genderMale">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Perempuan" <?php if ($data['gender'] == 'Perempuan') echo 'checked'; ?> required>
                            <label class="form-check-label" for="genderFemale">Perempuan</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Hobi</label>
                    <div>
                        <?php
                        $hobi_mahasiswa = isset($data['hobi']) ? explode(", ", $data['hobi']) : [];
                        $hobi_options = ['Membaca', 'Menulis', 'Olahraga', 'Musik'];

                        foreach ($hobi_options as $index => $hobi) {
                            $checked = in_array($hobi, $hobi_mahasiswa) ? 'checked' : '';
                            echo "
                            <div class='form-check form-check-inline'>
                                <input class='form-check-input' type='checkbox' name='hobi[]' id='hobi$index' value='$hobi' $checked>
                                <label class='form-check-label' for='hobi$index'>$hobi</label>
                            </div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="4" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>
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

                
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="mahasiswa.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>