<?php
include 'koneksi.php';

cekRole(['admin']);//hanya admin

cekLogin();

$result = $conn->query("SELECT dosen.*, prodi.nama_prodi 
                        FROM dosen 
                        LEFT JOIN prodi ON dosen.prodi_id = prodi.id"); // Query untuk join tabel dosen dan prodi

?>

<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
<head>
  <script src="assets/js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Data Dosen</title>
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/sticky-footer-navbar.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>



  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      user-select: none;
    }
  </style>
</head>
<body class="d-flex flex-column h-100">

<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Beranda</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="mahasiswa.php">Mahasiswa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="#" href="prodi.php">Prodi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="#" href="dosen.php">Dosen</a>
          </li>
        </ul>
        <div class="position-relative">
            <a href="logout.php" class="btn btn-outline-danger position-absolute top-0 end-0">Logout</a><br><br>
        </div>
      </div>
    </div>
  </nav>
</header>

<main class="flex-shrink-0">
  <div class="container">
  <h1 class="text-center">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

    <h2>Data Dosen</h2>
    <a href="create-dosen.php" class="btn btn-primary mb-3">Tambah Data</a> 

    <table id="example" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>NO</th>
          <th>NIP</th>
          <th>Nama Dosen</th>
          <th>Program Studi</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($data = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($data['nip']); ?></td>
            <td><?php echo htmlspecialchars($data['nama_dosen']); ?></td>
            <td><?php echo htmlspecialchars($data['nama_prodi']); ?></td>
            <td>
                <?php if ($data['foto']): ?>
                    <img src="<?php echo htmlspecialchars($data['foto']); ?>" alt="Foto Dosen" width="100">
                <?php else: ?>
                    Tidak Ada Foto
                <?php endif; ?>
            </td>

            <td>
              <a href="edit-dosen.php?nip=<?php echo $data['nip']; ?>" class="btn btn-primary btn-sm">Edit</a>
              <a href="delete.php?nip=<?php echo $data['nip']; ?>&table=dosen" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<script>
$(document).ready(function () {
    $('#example').DataTable({
        "language": {
            "search": "Cari data Dosen:",
            "zeroRecords": "Data tidak ditemukan", 
        }
    });
});
</script>



<script src="assets/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
