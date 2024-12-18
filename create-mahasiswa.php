<?php
include 'koneksi.php';

cekLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nim = $_POST['nim'];
    $gender = $_POST['gender'];
    $hobi = implode(", ", $_POST['hobi']);
    $alamat = $_POST['alamat'];
    $prodi_id = $_POST['prodi_id'];

    $cek_nim = $conn->query("select * from mahasiswa where nim = '$nim'");
    
    if($cek_nim->num_rows > 0){
        echo "<script>alert('NIM sudah digunakan! Silakan masukkan NIM yang berbeda.');</script>";
    }else{
            $sql = "INSERT INTO mahasiswa (nama, email, nim, gender, hobi, alamat, prodi_id) 
            VALUES ('$nama', '$email', '$nim', '$gender', '$hobi', '$alamat', '$prodi_id')";
       
        if ($conn->query($sql)) {
            header('Location: mahasiswa.php');
        } else {
                echo "Error: " . $conn->error;
        }
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
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Laki-laki" required>
                            <label class="form-check-label" for="genderMale">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Perempuan" required>
                            <label class="form-check-label" for="genderFemale">Perempuan</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Hobi</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="hobi[]" id="hobi1" value="Membaca">
                            <label class="form-check-label" for="hobi1">Membaca</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="hobi[]" id="hobi2" value="Menulis">
                            <label class="form-check-label" for="hobi2">Menulis</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="hobi[]" id="hobi3" value="Olahraga">
                            <label class="form-check-label" for="hobi3">Olahraga</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="hobi[]" id="hobi4" value="Musik">
                            <label class="form-check-label" for="hobi4">Musik</label>
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

                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="4" required></textarea>
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
