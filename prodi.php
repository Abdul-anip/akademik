<?php
include 'koneksi.php';

cekLogin();

$result = $conn->query("SELECT * FROM prodi");

?>

<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
  <head><script src="assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Sticky Footer Navbar Template · Bootstrap v5.3</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sticky-footer-navbar/">

    

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
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="mahasiswa.php">Mahasiswa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="#" href="prodi.php">Prodi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="#" href="index.php?page=dosen">Dosen</a>
          </li>
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
        <h2>Data Prodi</h2>
      
        <a href="create-prodi.php" class="btn btn-primary mb-3">Tambah Data</a> 
        
        <table class="table table-striped table-bordered">
            <tr>
                <th>NO</th>
                <th>Nama Prodi</th>
                <th>Jenjang</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            while ($data = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($data['nama_prodi']); ?></td>
                <td><?php echo htmlspecialchars($data['jenjang']); ?></td>
                <td><?php echo htmlspecialchars($data['keterangan']); ?></td>
                <td>
                    <a href="edit-prodi.php?id=<?php echo $data['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete.php?id=<?php echo $data['id']; ?>&table=prodi" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
  </div>
</main>

<script src="assets/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
