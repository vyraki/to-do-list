<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM tugas WHERE id = '$id'");
    $task = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $batas_waktu = $_POST['batas_waktu'];

    $query = "UPDATE tugas SET judul = '$judul', deskripsi = '$deskripsi', batas_waktu = '$batas_waktu' WHERE id = '$id'";
    mysqli_query($conn, $query);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="1.css">
</head>
<body style="background-image: url('img/B.jpg'); background-size: cover;">
    <h1>Edit Tugas</h1>
    <form action="" method="post">
        <input type="text" name="judul" value="<?= htmlspecialchars($task['judul']) ?>" required>
        <textarea  style="resize: none; width: 95%; height: 100px;" name="deskripsi" required><?= htmlspecialchars($task['deskripsi']) ?></textarea>
        <input type="datetime-local" name="batas_waktu" value="<?= $task['batas_waktu'] ?>" required>
        <button type="submit" name="update">Update Tugas</button>
    </form>
</body>
</html>