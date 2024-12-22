<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM tugas WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>