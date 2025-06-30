<?php
session_start();
include 'koneksi.php';

// Tangani logout
if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

if (isset($_POST['login'])) {
  $user = $_POST['username'];
  $pass = $_POST['password'];

  // Cek data dari database
  $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
  if (mysqli_num_rows($cek) > 0) {
    $_SESSION['user'] = $user;
    header("Location: index.php");
    exit();
  } else {
    $error = "Username atau password salah!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistem Pengurus</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      height: 100vh;
      background: linear-gradient(to right, #d3cce3, #e9e4f0);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-box {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h3 class="text-center mb-4">Login Sistem Pengurus</h3>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="remember">
        <label class="form-check-label">Ingat saya</label>
      </div>
      <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
    </form>
  </div>
</body>
</html>
