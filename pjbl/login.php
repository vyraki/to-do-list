<?php
include 'koneksi.php';

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  if (empty($username) || empty($password)) {
    $error = "Username dan password harus diisi!";
  } else {
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      header("Location: index.php");
      exit;
    } else {
      $error = "Username atau password salah!";
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body  style="background-image: url('img/bc1.jpg'); background-size: cover;">
<img src="img/logo_pjbl_note-removebg-preview.png" style="width: 200px; display: block; margin: 0 auto;" alt="">
  <div class="login">
    <h2>Login</h2>
    <form action="" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
      <?php if (isset($error)) { echo $error; } ?>
    </form>
    <hr>
    <p>Belum punya akun? <a href="regis.php">Daftar di sini</a></p>
  </div>
</body>
</html>