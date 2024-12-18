<?php
include 'koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna sudah login
$is_logged_in = isset($_SESSION['user_id']);
$level = isset($_SESSION['level']) ? $_SESSION['level'] : ''; // Ambil level pengguna
?>

<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
  <head>
    <script src="assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/blog.css" rel="stylesheet">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
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

        <div class="d-flex">
          <?php if (!$is_logged_in): ?>
            <!-- Tampilkan tombol login jika belum login -->
            <a href="login.php" class="btn btn-primary">Login</a>
          <?php else: ?>
            <!-- Tampilkan tombol logout jika sudah login -->
            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
</header>

<?php
// Routing halaman berdasarkan query string
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
if ($page == 'home') include 'home.php';
if ($page == 'mahasiswa') include 'mahasiswa.php';
if ($page == 'dosen') include 'dosen.php';
if ($page == 'prodi') include 'prodi.php';
?>

<footer class="footer mt-auto py-3 bg-body-tertiary">
  <div class="container">
    <span class="text-body-secondary">Place sticky footer content here.</span>
  </div>
</footer>
<script src="assets/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
