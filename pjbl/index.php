<?php
session_start();
include 'koneksi.php';
if (!isset($_SERVER['HTTP_REFERER'])) {
    header("Location: login.php");
    exit;
}

// Set local timezone
date_default_timezone_set('Asia/Jakarta');

// Function to display date in Indonesian format
function tanggal_indonesia($tanggal) {
    $bulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function waktu_24_jam($waktu) {
    $pecahkan = explode(' ', $waktu);
    return tanggal_indonesia($pecahkan[0]) . ' ' . $pecahkan[1];
}

// Function to check if the deadline has passed
function sudah_melewati_batas_waktu($batas_waktu) {
    $sekarang = new DateTime();
    $batas_waktu = new DateTime($batas_waktu);
    return $sekarang >= $batas_waktu;
}

// Mark task as completed
if (isset($_POST['selesai'])) {
    $id = $_POST['id'];
    $query = "UPDATE tugas SET selesai = 1 WHERE id = '$id'";
    mysqli_query($conn, $query);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Add new task
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $batas_waktu = $_POST['batas_waktu'];
    $query = "INSERT INTO tugas (judul, deskripsi, batas_waktu) VALUES ('$judul', '$deskripsi', '$batas_waktu')";
    mysqli_query($conn, $query);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all tasks
$tugas = mysqli_query($conn, "SELECT * FROM tugas ORDER BY batas_waktu ASC");
$tugas_list = [];
while ($row = mysqli_fetch_assoc($tugas)) {
    $tugas_list[] = $row;
}

$total_tugas = count($tugas_list);
$setengah = ceil($total_tugas / 2);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="1.css">
</head>
<body style="background-image: url('img/B.jpg'); background-size: cover;">
<img src="img/logo_pjbl_note-removebg-preview.png" style="width: 200px; display: block; margin: 0 auto;" alt="">
<form action="" method="post">
    <input type="text" name="judul" placeholder="Judul Tugas" required>
    <textarea style="resize: none; width: 95%; height: 100px;" name="deskripsi" placeholder="Deskripsi Tugas" required></textarea>
    <input type="datetime-local" name="batas_waktu" required>
    <button type="submit" name="tambah">Tambah Tugas</button>
</form>

<h2>Daftar Tugas</h2>
<div style="display: flex; justify-content: space-between; gap: 10px;">
    <div style="width: 48%;">
        <ul>
            <?php for ($i = 0; $i < $setengah; $i++): ?>
                <li>
                    <strong><?= htmlspecialchars($tugas_list[$i]['judul']); ?></strong>
                    <p><?= htmlspecialchars($tugas_list[$i]['deskripsi']); ?></p>
                    <p>Batas Waktu: <?= waktu_24_jam($tugas_list[$i]['batas_waktu']); ?></p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $tugas_list[$i]['id']; ?>">
                        <?php if ($tugas_list[$i]['selesai'] == 0): ?>
                            <?php if (sudah_melewati_batas_waktu($tugas_list[$i]['batas_waktu'])): ?>
                                <span style="color: red;">Sudah melewati batas waktu!</span>
                                <button type="submit" formaction="hapus.php?id=<?= $tugas_list[$i]['id']; ?>">Hapus</button>
                            <?php else: ?>
                                <button type="submit" name="selesai">Selesai</button>
                                <button type="submit" formaction="edit.php?id=<?= $tugas_list[$i]['id']; ?>">Edit</button>
                                <button type="submit" formaction="hapus.php?id=<?= $tugas_list[$i]['id']; ?>">Hapus</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <span style="color: green;">Sudah selesai!</span>
                            <button type="submit" formaction="hapus.php?id=<?= $tugas_list[$i]['id']; ?>">Hapus</button>
                        <?php endif; ?>
                    </form>
                </li>
            <?php endfor; ?>
        </ul>
    </div>

    <div style="width: 48%;">
        <ul>
            <?php for ($i = $setengah; $i < $total_tugas; $i++): ?>
                <li>
                    <strong><?= htmlspecialchars($tugas_list[$i]['judul']); ?></strong>
                    <p><?= htmlspecialchars($tugas_list[$i]['deskripsi']); ?></p>
                    <p>Batas Waktu: <?= waktu_24_jam($tugas_list[$i]['batas_waktu']); ?></p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $tugas_list[$i]['id']; ?>">
                        <?php if ($tugas_list[$i]['selesai'] == 0): ?>
                            <?php if (sudah_melewati_batas_waktu($tugas_list[$i]['batas_waktu'])): ?>
                                <span style="color: red;">Sudah melewati batas waktu!</span>
                                <button type="submit" formaction="hapus.php?id=<?= $tugas_list[$i]['id']; ?>">Hapus</button>
                            <?php else: ?>
                                <button type="submit" name="selesai">Selesai</button>
                                <button type="submit" formaction="edit.php?id=<?= $tugas_list[$i]['id']; ?>">Edit</button>
                                <button type="submit" formaction="hapus.php?id=<?= $tugas_list[$i]['id']; ?>">Hapus</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <span style="color: green;">Sudah selesai!</span>
                            <button type="submit" formaction="hapus.php?id=<?= $tugas_list[$i]['id']; ?>">Hapus</button>
                        <?php endif; ?>
                    </form>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
</body>
</html>