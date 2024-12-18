<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $level = $_POST['level'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    // Validasi username apakah sudah ada
    $check_username = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($check_username->num_rows > 0) {
        echo "Username already taken.";
    } else {

        $sql = "INSERT INTO users (username, email, level, password) VALUES ('$username', '$email', '$level', '$password')";
        if ($conn->query($sql)) {
            header('Location: login.php');
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>


<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Signup Template · Bootstrap v5.3</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
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
    </style>

    <link href="css/sign-in.css" rel="stylesheet">
  </head>
  <body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
      <form method="post">
        <img class="mb-4" src="assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Daftar</h1>

        <div class="form-floating">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
          <label for="floatingUsername">Username</label>
        </div>  

        <div class="form-floating">
          <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
          <label for="floatingInput">Email address</label>
        </div>

        <div class="form-floating">
          <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
          <label for="floatingPassword">Password</label>
        </div>
        
        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select class="form-control" id="level" name="level" required>
                <option value="staf">Staf</option>
                <option value="admin">Admin</option>
            </select>
        </div>


        <div class="form-check text-start my-3">
          <label class="form-check-label" for="flexCheckDefault">
          <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
          </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Sign Up</button>
        <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
      </form>
    </main>
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
