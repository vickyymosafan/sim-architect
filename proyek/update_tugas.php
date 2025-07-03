<?php
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $update = mysqli_query($koneksi, "UPDATE tugas_proyek SET status='$status' WHERE id='$id'");

    if ($update) {
        header("Location: tugas_harian.php");
        exit;
    } else {
        echo "Gagal update status: " . mysqli_error($koneksi);
    }
}
?>
