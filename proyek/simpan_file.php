<?php
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $file = $_FILES['gambar'];

    $namaFile = basename($file['name']);
    $targetDir = "../file_proyek/"; // <<< GANTI DI SINI
    $namaUnik = time() . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "_", $namaFile);
    $targetFile = $targetDir . $namaUnik;

    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'obj', 'stl', 'dwg'];
    $fileExt = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (in_array($fileExt, $allowedExt)) {
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Bikin folder jika belum ada
        }

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Insert dengan status_verifikasi default 'pending'
            $sql = "INSERT INTO file_gambar (deskripsi, gambar, status_verifikasi) VALUES ('$deskripsi', '$namaUnik', 'pending')";
            $query = mysqli_query($koneksi, $sql);

            if ($query) {
                echo "<script>alert('File berhasil diupload dan akan masuk ke antrian verifikasi!'); window.location.href='verifikasi.php';</script>";
            } else {
                echo "<div class='alert alert-danger'>Upload berhasil, tapi gagal simpan ke database: " . mysqli_error($koneksi) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Gagal meng-upload file ke server.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Tipe file <strong>.$fileExt</strong> tidak diperbolehkan.</div>";
    }
}
?>