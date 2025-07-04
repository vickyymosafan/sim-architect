<?php
require 'koneksi.php';
require_once 'includes/session_manager.php';
safe_session_start();

// Ambil input dari form
$user = trim($_POST['username']);
$pass = trim($_POST['password']);

// Cek di tabel petugas terlebih dahulu
$sql_petugas = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$user' AND password='$pass'");

if (mysqli_num_rows($sql_petugas) > 0) {
    $data = mysqli_fetch_array($sql_petugas);

    // Simpan session untuk petugas
    $_SESSION['id_petugas'] = $data['id_petugas'];
    $_SESSION['user'] = $user;
    $_SESSION['nama'] = $data['nama_petugas'];
    $_SESSION['level'] = $data['level'];

    // Arahkan sesuai level user
    if ($data['level'] == "proyek") {
        header('Location:proyek/proyek.php');
    } elseif ($data['level'] == "admin") {
        header('Location:admin/admin.php');
    } else {
        echo "<script>alert('Level tidak dikenali!'); window.location='index.php';</script>";
    }
} else {
    // Cek di tabel users untuk client
    $sql_client = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user' AND role='client'");

    if (mysqli_num_rows($sql_client) > 0) {
        $data = mysqli_fetch_array($sql_client);

        // Verifikasi password untuk client (menggunakan password_verify karena di-hash)
        if (password_verify($pass, $data['password'])) {
            // Simpan session untuk client
            $_SESSION['id_client'] = $data['id'];
            $_SESSION['user'] = $user;
            $_SESSION['nama'] = $data['first_name'] . ' ' . $data['last_name'];
            $_SESSION['level'] = 'client';

            header('Location:client/client.php');
        } else {
            echo "<script>alert('Username atau Password tidak ditemukan'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Username atau Password tidak ditemukan'); window.location='index.php';</script>";
    }
}
?>
