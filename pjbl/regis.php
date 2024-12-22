<?php
include 'koneksi.php';

if (isset($_POST['daftar'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  if (empty($username) || empty($password)) {
    $error = "Username dan password harus diisi!";
  } else {
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $result = $conn->query($query);

    if ($result) {
      header("Location: login.php");
      exit;
    } else {
      $error = "Gagal membuat akun!";
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registrasi</title>
  <link rel="stylesheet" href="regis.css">
</head>
<body  style="background-image: url('img/bc1.jpg'); background-size: cover;">
<img src="img/logo_pjbl_note-removebg-preview.png" style="width: 200px; display: block; margin: 0 auto;" alt="" class="fixed-image">
  <div class="regis">
    <h2>Registrasi</h2>
    <form action="" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="daftar">Daftar</button>
      <?php if (isset($error)) { echo $error; } ?>
    </form>
    <hr>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
  </div>
</body>
</html>