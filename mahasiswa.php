<?php
include 'koneksi.php';



cekLogin();

$sql = "SELECT mahasiswa.id, mahasiswa.nama, mahasiswa.email, mahasiswa.nim, 
           mahasiswa.gender, mahasiswa.hobi, mahasiswa.alamat, prodi.nama_prodi
    FROM mahasiswa
    LEFT JOIN prodi ON mahasiswa.prodi_id = prodi.id";


$result = $conn->query($sql);

if(!$result){
  die("Eror pada query: " . $conn->error);
}

// Cek apakah pengguna sudah login
$is_logged_in = isset($_SESSION['user_id']);
$level = isset($_SESSION['level']) ? $_SESSION['level'] : ''; // Ambil level pengguna
?>

<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
  <head><script src="assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Mahasiswa</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sticky-footer-navbar/">

    <!-- DataTables CSS dan JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
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

          <?php if ($is_logged_in): ?>
            <li class="nav-item">
              <a class="nav-link" href="mahasiswa.php">Mahasiswa</a>
            </li>
            
            <?php if ($level === 'admin'): ?>
              <li class="nav-item">
                <a class="nav-link" href="prodi.php">Prodi</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="dosen.php">Dosen</a>
              </li>
            <?php endif; ?>

          <?php endif; ?>
        </ul>

        <div class="position-relative">
            <a href="logout.php" class="btn btn-outline-danger position-absolute top-0 end-0">Logout</a><br><br>
        </div>
      </div>
    </div>
  </nav>
</header>

  
<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="text-center">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <h2>Data Mahasiswa</h2>
      
        <a href="create-mahasiswa.php" class="btn btn-primary mb-3">Tambah Data</a> 
        
        <table id="mahasiswa-tabel" class="table table-striped table-bordered" >
          <thead>
            <tr>
                <th>NO</th>
                <th>Nama</th>
                <th>Email</th>
                <th>NIM</th>
                <th>Jenis Kelamin</th>
                <th>Hobi</th>
                <th>Alamat</th>
                <th>Program Study</th>
                <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while ($data = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($data['nama']); ?></td>
                <td><?php echo htmlspecialchars($data['email']); ?></td>
                <td><?php echo htmlspecialchars($data['nim']); ?></td>
                <td><?php echo htmlspecialchars($data['gender']); ?></td>
                <td><?php echo htmlspecialchars($data['hobi']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($data['alamat'])); ?></td>
                <td><?php echo htmlspecialchars($data['nama_prodi']); ?></td>
                <td>
                    <a href="edit-mahasiswa.php?id=<?php echo $data['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete.php?id=<?php echo $data['id']; ?>&table=mahasiswa" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
  </div>
</main>

<script>
$('#mahasiswa-tabel').DataTable({
    "language": {
        "search": "Cari data Mahasiswa:",
        "zeroRecords": "Data tidak ditemukan", 
    }
});

</script>

<script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
 